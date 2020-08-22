<?php

namespace App\Repository;

use App\Entity\DevSkills;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DevSkills|null find($id, $lockMode = null, $lockVersion = null)
 * @method DevSkills|null findOneBy(array $criteria, array $orderBy = null)
 * @method DevSkills[]    findAll()
 * @method DevSkills[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DevSkillsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DevSkills::class);
    }

    // /**
    //  * @return DevSkills[] Returns an array of DevSkills objects
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
    public function findOneBySomeField($value): ?DevSkills
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
