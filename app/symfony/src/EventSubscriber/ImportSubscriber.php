<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use App\Event\ImportEvent;
use App\Service\Mailer\Sender;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ImportSubscriber implements EventSubscriberInterface
{
    private Sender $sender;

    public function __construct(Sender $sender)
    {
        $this->sender = $sender;
    }

    public function onCompleted(ImportEvent $event): void
    {
        // @send report by email
    }

    public static function getSubscribedEvents(): array
    {
        return [
            ImportEvent::COMPLETED => 'onCompleted',
        ];
    }
}
