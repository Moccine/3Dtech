<?php

declare(strict_types=1);

namespace App\Service\Import;

use App\Service\Log\LogWriterService;
use League\Csv\Reader;
use League\Csv\Statement;

class CsvReaderService implements CsvReaderInterface
{
    public function process(string $path, LogWriterService $logWriter): void
    {
        $reader = Reader::createFromPath($path, 'r');
        $reader->setHeaderOffset(0);

        $records = Statement::create()->process($reader);
        $headers = $records->getHeader();

        $logWriter->writeln(LogWriterService::LEVEL_NOTICE, sprintf('je lis le fichier %s', $path));
    }
}
