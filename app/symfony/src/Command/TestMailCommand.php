<?php

namespace App\Command;

use App\Service\Mailer\Sender;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class TestMailCommand extends Command
{
    protected static $defaultName = 'TestMail';
    private Sender $sender;

    /**
     * TestMailCommand constructor.
     * @param Sender $sender
     */
    public function __construct(Sender $sender)
    {
        parent::__construct();
        $this->sender = $sender;
    }

    protected function configure()
    {
        $this
            ->setDescription('test mail')
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $io = new SymfonyStyle($input, $output);
            $to = 'sow.mouctar@gmail.com';
            $subject = 'demande de devis';
            $content = $this->sender->doTemplate('ask_of_quote/email_confirm.html.twig');
            $bindings = [];
            $attachments = null;
            $this->sender->deliver($to, $subject, $content, $bindings, $attachments);
        }catch (\Exception $e){
            dd($e);
        }


        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return Command::SUCCESS;
    }
}
