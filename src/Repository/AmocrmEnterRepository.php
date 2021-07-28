<?php

namespace App\Repository;

use App\Entity\AmocrmEnter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AmocrmEnter|null find($id, $lockMode = null, $lockVersion = null)
 * @method AmocrmEnter|null findOneBy(array $criteria, array $orderBy = null)
 * @method AmocrmEnter[]    findAll()
 * @method AmocrmEnter[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AmocrmEnterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AmocrmEnter::class);
    }

    // /**
    //  * @return AmocrmEnter[] Returns an array of AmocrmEnter objects
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
    public function findOneBySomeField($value): ?AmocrmEnter
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
