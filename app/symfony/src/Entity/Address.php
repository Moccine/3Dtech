<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Traits\AddressTrait;
use App\Entity\Traits\IdentifiableTrait;
use App\Repository\AddressRepository;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;


/**
 * @ORM\Entity(repositoryClass=AddressRepository::class)
 */
class Address
{
    public const FRANCE = 'France';
    public static array $countries = [
        self::FRANCE => 'France',
    ];
    use IdentifiableTrait;
    use AddressTrait;
}
