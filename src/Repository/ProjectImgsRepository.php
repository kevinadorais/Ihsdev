<?php

namespace App\Repository;

use App\Entity\ProjectImgs;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ProjectImgs|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProjectImgs|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProjectImgs[]    findAll()
 * @method ProjectImgs[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjectImgsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProjectImgs::class);
    }

    // /**
    //  * @return ProjectImgs[] Returns an array of ProjectImgs objects
    //  */
    
    public function findByProject($projectId)
    {
        return $this->createQueryBuilder('img')
            ->andWhere('img.projects = :val')
            ->setParameter('val', $projectId)
            ->orderBy('img.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    /*
    public function findOneBySomeField($value): ?ProjectImgs
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
