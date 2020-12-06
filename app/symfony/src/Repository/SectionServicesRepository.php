<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\SectionServices;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SectionServices|null find($id, $lockMode = null, $lockVersion = null)
 * @method SectionServices|null findOneBy(array $criteria, array $orderBy = null)
 * @method SectionServices[]    findAll()
 * @method SectionServices[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SectionServicesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SectionServices::class);
    }

    // /**
    //  * @return SectionServices[] Returns an array of SectionServices objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SectionServices
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
