<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Traits\AddressTrait;
use App\Entity\Traits\CreatedAtTrait;
use App\Entity\Traits\IdentifiableTrait;
use App\Entity\Traits\UpdatedAtTrait;
use App\Repository\AddressRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AddressRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Address
{
    public const FRANCE = 'France';
    public static array $countries = [
        self::FRANCE => self::FRANCE
    ];

    use IdentifiableTrait;
    use CreatedAtTrait;
    use UpdatedAtTrait;
    use AddressTrait;
}

