<?php

declare(strict_types=1);

namespace App\Command;

use App\Event\ImportEvent;
use App\Manager\TaskManager;
use App\Service\Import\CsvReaderService;
use App\Service\Log\LogWriterService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Command\LockableTrait;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Finder\Finder;

class MistralImportCommand extends Command
{
    use LockableTrait;

    /**
     * @var string
     */
    protected static $defaultName = 'netrent:mistral:import';

    /**
     * @var CsvReaderService
     */
    private $csvReader;

    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * @var array
     */
    private $files = [];

    /**
     * @var LogWriterService
     */
    private $logWriter;

    /**
     * @var TaskManager
     */
    private $taskManager;

    public function __construct(
        CsvReaderService $csvReaderService,
        EventDispatcherInterface $eventDispatcher,
        LogWriterService $logWriterService,
        TaskManager $taskManager,
        ?string $name = null
    ) {
        $this->csvReader = $csvReaderService;
        $this->eventDispatcher = $eventDispatcher;
        $this->logWriter = $logWriterService;
        $this->taskManager = $taskManager;

        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Import files from Mistral')
            ->addArgument('folder', InputArgument::REQUIRED, 'Folder which contains files to import')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        if (!$this->lock()) {
            $io->warning('The command is already running in another process.');

            return Command::SUCCESS;
        }

        $finder = new Finder();
        $folder = $input->getArgument('folder');
        $logFile = sprintf('%s.log', date('d-m-Y-H-i-s'));

        $task = $this->taskManager->start(self::$defaultName, $logFile);
        $this->logWriter->listen($logFile);

        $io->note(sprintf('Looking into %s folder ...', $folder));

        foreach ($finder->files()->in($folder) as $file) {
            $this->files[] = $file;
        }

        $output->writeln($this->files);
        $this->sort();

        foreach ($this->files as $file) {
            $output->writeln(sprintf('Parsing %s ...', $file->getRelativePathname()));
            $this->csvReader->process($file, $this->logWriter);
        }

        $this->eventDispatcher->dispatch(
            new ImportEvent(),
            ImportEvent::COMPLETED
        );

        $this->release();
        $this->taskManager->completed($task);

        return Command::SUCCESS;
    }

    private function sort(): void
    {
    }
}
