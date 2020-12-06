<?php

namespace App\Repository;

use App\Entity\Deadlines;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Deadlines|null find($id, $lockMode = null, $lockVersion = null)
 * @method Deadlines|null findOneBy(array $criteria, array $orderBy = null)
 * @method Deadlines[]    findAll()
 * @method Deadlines[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DeadlinesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Deadlines::class);
    }

    // /**
    //  * @return Deadlines[] Returns an array of Deadlines objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Deadlines
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
