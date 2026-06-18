<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\ExecutableFinder;
use Symfony\Component\Process\Process;

#[AsCommand(
    name: 'app:backup',
    description: 'Create a SQL dump and a tar.gz archive of uploaded media.',
)]
class BackupCommand extends Command
{
    public function __construct(
        #[Autowire('%kernel.project_dir%')]
        private readonly string $projectDir,
        #[Autowire('%env(resolve:DATABASE_URL)%')]
        private readonly string $databaseUrl,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addOption(
                'output-dir',
                null,
                InputOption::VALUE_REQUIRED,
                'Directory where backup files are written.',
                'var/backups'
            )
            ->addOption(
                'media-dir',
                null,
                InputOption::VALUE_REQUIRED,
                'Directory to archive, relative to the project directory or absolute.',
                'public/oeuvre-medias'
            )
            ->addOption('skip-database', null, InputOption::VALUE_NONE, 'Do not create the SQL dump.')
            ->addOption('skip-media', null, InputOption::VALUE_NONE, 'Do not create the media archive.')
            ->addOption('skip-upload', null, InputOption::VALUE_NONE, 'Do not upload backup files to the SSH server.')
            ->addOption('local-keep', null, InputOption::VALUE_REQUIRED, 'Number of local backup sets to keep.', 1)
            ->addOption('remote-keep', null, InputOption::VALUE_REQUIRED, 'Number of remote backup sets to keep.', 7)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $timestamp = (new \DateTimeImmutable())->format('Ymd_His');
        $outputDir = $this->resolvePath((string) $input->getOption('output-dir'));
        $createdFiles = [];

        if ($input->getOption('skip-database') && $input->getOption('skip-media')) {
            $io->error('Nothing to backup: --skip-database and --skip-media cannot be used together.');

            return Command::INVALID;
        }

        if (!is_dir($outputDir) && !mkdir($outputDir, 0755, true) && !is_dir($outputDir)) {
            $io->error(sprintf('Unable to create backup directory "%s".', $outputDir));

            return Command::FAILURE;
        }

        try {
            if (!$input->getOption('skip-database')) {
                $createdFiles[] = $this->dumpDatabase($outputDir, $timestamp, $io);
            }

            if (!$input->getOption('skip-media')) {
                $mediaDir = $this->resolvePath((string) $input->getOption('media-dir'));
                $createdFiles[] = $this->archiveMedia($mediaDir, $outputDir, $timestamp, $io);
            }

            if (!$input->getOption('skip-upload')) {
                $this->uploadFiles(
                    $createdFiles,
                    $this->getRemoteDirectory(),
                    (int) $input->getOption('remote-keep'),
                    $io
                );
            }

            $this->cleanupLocalBackups($outputDir, (int) $input->getOption('local-keep'), $io);
        } catch (\Throwable $exception) {
            $io->error($exception->getMessage());

            return Command::FAILURE;
        }

        $io->success('Backup completed.');
        $io->listing($createdFiles);

        return Command::SUCCESS;
    }

    private function dumpDatabase(string $outputDir, string $timestamp, SymfonyStyle $io): string
    {
        $dumpBinary = $this->findExecutable(['mariadb-dump', 'mysqldump']);
        $connection = $this->parseDatabaseUrl();
        $dumpPath = sprintf('%s/database_%s.sql', $outputDir, $timestamp);
        $dumpFile = fopen($dumpPath, 'wb');

        if ($dumpFile === false) {
            throw new \RuntimeException(sprintf('Unable to write SQL dump "%s".', $dumpPath));
        }

        $command = [
            $dumpBinary,
            '--single-transaction',
            '--quick',
            '--routines',
            '--triggers',
            '--events',
            '--host='.$connection['host'],
            '--user='.$connection['user'],
        ];

        if ($connection['port'] !== null) {
            $command[] = '--port='.$connection['port'];
        }

        $command[] = $connection['database'];

        $io->section('SQL dump');
        $process = new Process($command, null, ['MYSQL_PWD' => $connection['password']]);
        $process->setTimeout(null);

        try {
            $process->mustRun(function (string $type, string $buffer) use ($dumpFile, $io): void {
                if ($type === Process::OUT) {
                    fwrite($dumpFile, $buffer);

                    return;
                }

                $io->write($buffer);
            });
        } catch (ProcessFailedException $exception) {
            @unlink($dumpPath);

            throw new \RuntimeException(sprintf('SQL dump failed: %s', trim($exception->getProcess()->getErrorOutput())));
        } finally {
            fclose($dumpFile);
        }

        return $dumpPath;
    }

    private function archiveMedia(string $mediaDir, string $outputDir, string $timestamp, SymfonyStyle $io): string
    {
        if (!is_dir($mediaDir)) {
            throw new \RuntimeException(sprintf('Media directory "%s" does not exist.', $mediaDir));
        }

        $tarBinary = $this->findExecutable(['tar']);
        $archivePath = sprintf('%s/oeuvre-medias_%s.tar.gz', $outputDir, $timestamp);

        $io->section('Media archive');
        $process = new Process([
            $tarBinary,
            '-czf',
            $archivePath,
            '-C',
            dirname($mediaDir),
            basename($mediaDir),
        ]);
        $process->setTimeout(null);

        try {
            $process->mustRun();
        } catch (ProcessFailedException $exception) {
            @unlink($archivePath);

            throw new \RuntimeException(sprintf('Media archive failed: %s', trim($exception->getProcess()->getErrorOutput())));
        }

        return $archivePath;
    }

    private function uploadFiles(array $files, string $remoteDir, int $remoteKeep, SymfonyStyle $io): void
    {
        if ($remoteKeep < 1) {
            throw new \RuntimeException('--remote-keep must be greater than or equal to 1.');
        }

        $rsyncBinary = $this->findExecutable(['rsync']);
        $sshBinary = $this->findExecutable(['ssh']);
        $connection = $this->getSshConnection();
        $remoteTarget = sprintf('%s@%s:%s/', $connection['username'], $connection['host'], $remoteDir);
        $knownHostsFile = $this->projectDir.'/var/ssh_known_hosts';
        $sshOptions = [
            '-o',
            'StrictHostKeyChecking=accept-new',
            '-o',
            'UserKnownHostsFile='.$knownHostsFile,
            '-p',
            (string) $connection['port'],
        ];

        if (!is_dir(dirname($knownHostsFile)) && !mkdir(dirname($knownHostsFile), 0755, true) && !is_dir(dirname($knownHostsFile))) {
            throw new \RuntimeException(sprintf('Unable to create SSH directory "%s".', dirname($knownHostsFile)));
        }

        $io->section('Rsync upload');
        $this->runSshCommand($sshBinary, $sshOptions, $connection, sprintf('mkdir -p %s', $this->shellQuote($remoteDir)));

        $process = new Process(array_merge(
            [$rsyncBinary, '-az', '-e', $this->buildSshCommand($sshBinary, $sshOptions)],
            $files,
            [$remoteTarget]
        ));
        $process->setTimeout(null);

        try {
            $process->mustRun();
        } catch (ProcessFailedException $exception) {
            throw new \RuntimeException(sprintf('Rsync upload failed: %s', trim($exception->getProcess()->getErrorOutput())));
        }

        $this->cleanupRemoteBackups($sshBinary, $sshOptions, $connection, $remoteDir, $remoteKeep);
    }

    private function cleanupLocalBackups(string $outputDir, int $keep, SymfonyStyle $io): void
    {
        if ($keep < 1) {
            throw new \RuntimeException('--local-keep must be greater than or equal to 1.');
        }

        $backupSets = $this->findLocalBackupSets($outputDir);
        $expiredBackupSets = array_slice($backupSets, $keep);

        foreach ($expiredBackupSets as $backupSet) {
            foreach ($backupSet as $file) {
                @unlink($file);
            }
        }

        if ($expiredBackupSets !== []) {
            $io->note(sprintf('Removed %d old local backup set(s).', count($expiredBackupSets)));
        }
    }

    private function cleanupRemoteBackups(
        string $sshBinary,
        array $sshOptions,
        array $connection,
        string $remoteDir,
        int $keep,
    ): void {
        $remoteScript = sprintf(
            <<<'SH'
set -eu
cd %s
for stamp in $(
    for file in database_*.sql oeuvre-medias_*.tar.gz; do
        [ -e "$file" ] || continue
        stamp="${file#database_}"
        stamp="${stamp#oeuvre-medias_}"
        stamp="${stamp%%.sql}"
        stamp="${stamp%%.tar.gz}"
        printf '%%s\n' "$stamp"
    done | sort -ru | tail -n +%d
); do
    rm -f "database_${stamp}.sql" "oeuvre-medias_${stamp}.tar.gz"
done
SH,
            $this->shellQuote($remoteDir),
            $keep + 1
        );

        $this->runSshCommand($sshBinary, $sshOptions, $connection, $remoteScript);
    }

    private function findLocalBackupSets(string $outputDir): array
    {
        $sets = [];
        $files = glob($outputDir.'/{database_*.sql,oeuvre-medias_*.tar.gz}', GLOB_BRACE);

        foreach ($files === false ? [] : $files as $file) {
            if (!preg_match('/(?:database|oeuvre-medias)_(\d{8}_\d{6})\.(?:sql|tar\.gz)$/', $file, $matches)) {
                continue;
            }

            $sets[$matches[1]][] = $file;
        }

        krsort($sets);

        return array_values($sets);
    }

    private function runSshCommand(
        string $sshBinary,
        array $sshOptions,
        array $connection,
        string $remoteCommand,
    ): void {
        $process = new Process(array_merge(
            [$sshBinary],
            $sshOptions,
            [sprintf('%s@%s', $connection['username'], $connection['host']), $remoteCommand]
        ));
        $process->setTimeout(null);

        try {
            $process->mustRun();
        } catch (ProcessFailedException $exception) {
            throw new \RuntimeException(sprintf('SSH command failed: %s', trim($exception->getProcess()->getErrorOutput())));
        }
    }

    private function parseDatabaseUrl(): array
    {
        $parts = parse_url($this->databaseUrl);

        if ($parts === false || empty($parts['path'])) {
            throw new \RuntimeException('DATABASE_URL is invalid or does not contain a database name.');
        }

        return [
            'host' => $parts['host'] ?? 'localhost',
            'port' => $parts['port'] ?? null,
            'user' => isset($parts['user']) ? rawurldecode($parts['user']) : '',
            'password' => isset($parts['pass']) ? rawurldecode($parts['pass']) : '',
            'database' => rawurldecode(ltrim($parts['path'], '/')),
        ];
    }

    private function resolvePath(string $path): string
    {
        if (str_starts_with($path, '/')) {
            return rtrim($path, '/');
        }

        return rtrim($this->projectDir.'/'.$path, '/');
    }

    private function getSshConnection(): array
    {
        return [
            'host' => $this->getRequiredEnv('SSH_HOST'),
            'port' => (int) ($this->getEnv('SSH_PORT') ?: 22),
            'username' => $this->getRequiredEnv('SSH_USERNAME'),
        ];
    }

    private function getRemoteDirectory(): string
    {
        $remoteDir = $this->getRequiredEnv('SSH_REMOTE_DIR');

        return rtrim((string) $remoteDir, '/');
    }

    private function getRequiredEnv(string $name): string
    {
        $value = $this->getEnv($name);

        if ($value === null || $value === '') {
            throw new \RuntimeException(sprintf('Missing environment variable "%s".', $name));
        }

        return $value;
    }

    private function getEnv(string $name): ?string
    {
        if (isset($_ENV[$name])) {
            return (string) $_ENV[$name];
        }

        if (isset($_SERVER[$name])) {
            return (string) $_SERVER[$name];
        }

        $value = getenv($name);

        return $value === false ? null : $value;
    }

    private function shellQuote(string $value): string
    {
        return "'".str_replace("'", "'\\''", $value)."'";
    }

    private function buildSshCommand(string $sshBinary, array $sshOptions): string
    {
        $command = array_merge([$sshBinary], $sshOptions);

        return implode(' ', array_map(fn (string $argument): string => $this->shellQuote($argument), $command));
    }

    private function findExecutable(array $names): string
    {
        $finder = new ExecutableFinder();

        foreach ($names as $name) {
            $executable = $finder->find($name);

            if ($executable !== null) {
                return $executable;
            }
        }

        throw new \RuntimeException(sprintf('Missing executable: install one of "%s".', implode('", "', $names)));
    }
}
