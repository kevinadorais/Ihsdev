<?php

namespace App\Repository;

use App\Entity\AboutText;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AboutText|null find($id, $lockMode = null, $lockVersion = null)
 * @method AboutText|null findOneBy(array $criteria, array $orderBy = null)
 * @method AboutText[]    findAll()
 * @method AboutText[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AboutTextRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AboutText::class);
    }

    // /**
    //  * @return AboutText[] Returns an array of AboutText objects
    //  */

    public function sortByPosition()
    {
        return $this->createQueryBuilder('text')
            ->orderBy('text.textPosition', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    /*
    public function findOneBySomeField($value): ?AboutText
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
