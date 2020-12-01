<?php

declare(strict_types=1);

namespace App\Service\Import;

use App\Service\Log\LogWriterService;

interface CsvReaderInterface
{
    public function process(string $path, LogWriterService $logWriter): void;
}
