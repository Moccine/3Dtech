<?php

declare(strict_types=1);

namespace App\Command;

use App\Akeneo\AkeneoService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Contracts\Translation\TranslatorInterface;

class ImportCatalogCommand extends Command
{
    protected static $defaultName = 'netrent:import:catalog';
    private AkeneoService $akeneoService;
    private TranslatorInterface $translator;

    /**
     * ImportCatalogCommand constructor.
     */
    public function __construct(AkeneoService $akeneoService, TranslatorInterface $translator)
    {
        parent::__construct();

        $this->akeneoService = $akeneoService;
        $this->translator = $translator;
    }

    protected function configure()
    {
        $this->setDescription('Import pim catalog');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        try {
            $this->akeneoService->importCategoriesAndFamilies();
            $this->akeneoService->importProductAndAttributes();
            $io->success($this->translator->trans('app.command.import.catalog.success'));

            return Command::SUCCESS;
        } catch (\Exception $exception) {
            $io->error(sprintf('%s : %s', $this->translator->trans('app.command.import.catalog.failed'), $exception->getMessage()));
        }
    }
}
