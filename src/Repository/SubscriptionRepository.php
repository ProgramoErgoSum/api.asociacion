<?php

namespace App\Repository;

use App\Entity\Subscription;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class SubscriptionRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Subscription::class);
    }

    public function formValidate($request)
    {
        if(!isset($request['inDate']) || !isset($request['outDate']) || !isset($request['info']) || !isset($request['price']) )
            return false;

        foreach($request as $key=>$value){
            switch($key){
                case 'inDate':
                case 'outDate':
                    $date = \DateTime::createFromFormat('Y-m-d', $value);
                    if(!$date || $date->format('Y-m-d') != $value)
                        return false;
                    break;
                case 'info':
                    if(empty($value))
                        return false;
                    break;
                case 'price':
                    if(!is_numeric($value)) 
                        return false;
                    break;
            }
        }
        
        return true;
    }
}