<?php

declare(strict_types=1);

namespace App\Service\Comparator;

interface ComparatorInterface
{
    public function getAttributes(): array;

    public function getMachines(): array;
}
