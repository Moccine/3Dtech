<?php

declare(strict_types=1);

namespace App\Event;

use Symfony\Contracts\EventDispatcher\Event;

class ImportEvent extends Event
{
    public const COMPLETED = 'app.import.completed';
}
