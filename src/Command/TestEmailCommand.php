<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

#[AsCommand(
    name: 'app:test-email',
    description: 'Send a test email to check DSN configuration',
)]
class TestEmailCommand extends Command
{
    private MailerInterface $mailer;

    public function __construct( MailerInterface $mailer)
    {
        $this->mailer = $mailer;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addOption('from', null, InputOption::VALUE_REQUIRED, 'From email address')
            ->addOption('to', null, InputOption::VALUE_REQUIRED, 'To email address')
        ;
    }

    /**
     * @throws TransportExceptionInterface
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $from = $input->getOption('from');
        $to = $input->getOption('to');

        if (!filter_var($from, FILTER_VALIDATE_EMAIL)) {
            $io->error("Invalid '--from' email address");
            return Command::FAILURE;
        }

        if (!filter_var($to, FILTER_VALIDATE_EMAIL)) {
            $io->error("Invalid '--to' email address");
            return Command::FAILURE;
        }

        $email = (new Email())
            ->from($from)
            ->to($to)
            ->subject('Test email')
            ->text('This is a test email to check the DSN configuration.');

        $this->mailer->send($email);

        $io->info('Test email sent');

        return Command::SUCCESS;
    }
}
