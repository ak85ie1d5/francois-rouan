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
