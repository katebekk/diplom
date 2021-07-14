<?php

namespace App\Repository;

use App\Entity\Passing;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Passing|null find($id, $lockMode = null, $lockVersion = null)
 * @method Passing|null findOneBy(array $criteria, array $orderBy = null)
 * @method Passing[]    findAll()
 * @method Passing[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PassingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Passing::class);
    }

    // /**
    //  * @return Passing[] Returns an array of Passing objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Passing
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
