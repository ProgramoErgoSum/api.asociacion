<?php

namespace App\Repository;

use App\Entity\C;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method C|null find($id, $lockMode = null, $lockVersion = null)
 * @method C|null findOneBy(array $criteria, array $orderBy = null)
 * @method C[]    findAll()
 * @method C[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, C::class);
    }

//    /**
//     * @return C[] Returns an array of C objects
//     */
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
    public function findOneBySomeField($value): ?C
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
