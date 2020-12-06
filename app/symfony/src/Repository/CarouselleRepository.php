<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\Carouselle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Carouselle|null find($id, $lockMode = null, $lockVersion = null)
 * @method Carouselle|null findOneBy(array $criteria, array $orderBy = null)
 * @method Carouselle[]    findAll()
 * @method Carouselle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CarouselleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Carouselle::class);
    }

    // /**
    //  * @return Carouselle[] Returns an array of Carouselle objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Carouselle
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
