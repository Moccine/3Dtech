<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use App\Event\SubmissionEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class SubmissionSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            SubmissionEvent::SAVED => 'onSubmissionSaved',
        ];
    }

    public function onSubmissionSaved()
    {
        //TODO
    }
}
