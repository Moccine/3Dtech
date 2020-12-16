<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\MachineAttribute;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MachineAttribute|null find($id, $lockMode = null, $lockVersion = null)
 * @method MachineAttribute|null findOneBy(array $criteria, array $orderBy = null)
 * @method MachineAttribute[]    findAll()
 * @method MachineAttribute[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MachineAttributeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MachineAttribute::class);
    }
}
