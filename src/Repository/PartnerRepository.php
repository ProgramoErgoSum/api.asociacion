<?php

namespace App\Repository;

use App\Entity\Partner;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class PartnerRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Partner::class);
    }

    public function formValidate($request)
    {
        if(!isset($request['name']) || !isset($request['surname']) || !isset($request['email']) || !isset($request['active']) || !isset($request['role']))
            return false;

        foreach($request as $key=>$value){
            switch($key){
                case 'name':
                case 'surname':
                    if(empty($value))
                        return false;
                    break;
                case 'email':
                    if(!strpos($value, "@") || !strpos($value, ".")) 
                        return false;
                    break;
                case 'active':
                case 'role':
                    if(!is_numeric($value)) 
                        return false;
                    break;
            }
        }
        
        return true;
    }
}
