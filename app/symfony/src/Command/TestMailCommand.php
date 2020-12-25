<?php

namespace App\Command;

use App\Entity\Client;
use App\Entity\User;
use App\Service\Mailer\Sender;
use Doctrine\ORM\EntityManagerInterface;
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
    private EntityManagerInterface $em;

    /**
     * TestMailCommand constructor.
     */
    public function __construct(Sender $sender, EntityManagerInterface $em)
    {
        parent::__construct();
        $this->sender = $sender;
        $this->em = $em;
    }

    protected function configure()
    {
        $this
            ->setDescription('test mail')
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $io = new SymfonyStyle($input, $output);
            $to = 'sow.mouctar@gmail.com';
            $subject = 'demande de devis';
            /** @var Client $client */
            $client = $this->em->getRepository(Client::class)->find(1);
            $alertInscription = $this->sender->doTemplate('security/alert_new_inscription_mail.html.twig', [
                'client' => $client
            ]);
            $this->sender->deliver(
                $_ENV['AGENCY_EMAIL'],
                'nouvelle inscription',
                $alertInscription,
                [],
                []
            );
        } catch (\Exception $e) {
            dd($e);
        }


        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return Command::SUCCESS;
    }
}
