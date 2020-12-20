<?php

namespace App\Repository;

use App\Entity\AskOfQuote;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AskOfQuote|null find($id, $lockMode = null, $lockVersion = null)
 * @method AskOfQuote|null findOneBy(array $criteria, array $orderBy = null)
 * @method AskOfQuote[]    findAll()
 * @method AskOfQuote[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AskOfQuoteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AskOfQuote::class);
    }

    // /**
    //  * @return AskOfQuote[] Returns an array of AskOfQuote objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AskOfQuote
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
