<?php

namespace App\Repository;

use App\Entity\LessonStage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method LessonStage|null find($id, $lockMode = null, $lockVersion = null)
 * @method LessonStage|null findOneBy(array $criteria, array $orderBy = null)
 * @method LessonStage[]    findAll()
 * @method LessonStage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LessonStageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LessonStage::class);
    }

    // /**
    //  * @return LessonStage[] Returns an array of LessonStage objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?LessonStage
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
