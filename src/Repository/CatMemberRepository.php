<?php

namespace App\Repository;

use App\Entity\CatMember;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CatMember|null find($id, $lockMode = null, $lockVersion = null)
 * @method CatMember|null findOneBy(array $criteria, array $orderBy = null)
 * @method CatMember[]    findAll()
 * @method CatMember[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CatMemberRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CatMember::class);
    }

    // /**
    //  * @return CatMember[] Returns an array of CatMember objects
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
    public function findOneBySomeField($value): ?CatMember
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
