<?php

declare(strict_types=1);

namespace App\Twig;

use App\Entity\Parameter;
use Doctrine\ORM\EntityManagerInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class ParameterExtension extends AbstractExtension
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getFilters()
    {
        return [
            new TwigFilter('parameter', [$this, 'getParameterValue']),
        ];
    }

    public function getParameterValue(string $code): string
    {
        $parameter = $this->entityManager->getRepository(Parameter::class)->findOneByCode($code);

        return $parameter instanceof Parameter ? $parameter->getValue() : '';
    }
}
