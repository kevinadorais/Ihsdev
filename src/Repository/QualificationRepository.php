<?php

namespace App\Repository;

use App\Entity\Qualification;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Qualification|null find($id, $lockMode = null, $lockVersion = null)
 * @method Qualification|null findOneBy(array $criteria, array $orderBy = null)
 * @method Qualification[]    findAll()
 * @method Qualification[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QualificationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Qualification::class);
    }

    // /**
    //  * @return Qualification[] Returns an array of Qualification objects
    //  */
    public function sortByPosition()
    {
        return $this->createQueryBuilder('qualif')
            ->orderBy('qualif.position', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    /*
    public function findOneBySomeField($value): ?Qualification
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}