<?php

namespace App\Repository;

use App\Entity\Partner;
//use App\Entity\Subscription;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class PartnerRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Partner::class);
    }


    public function findBySalt($salt = null)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.salt = :val')
            ->setParameter('val', $salt)
            //->orderBy('p.id', 'ASC')
            //->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }

}
