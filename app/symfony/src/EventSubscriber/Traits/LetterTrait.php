<?php

declare(strict_types=1);

namespace App\EventSubscriber\Traits;

use App\Entity\Letter;

trait LetterTrait
{
    private function getLetterInfo($string)
    {
        return $this->em->getRepository(Letter::class)->findOneByCode($string);
    }
}
