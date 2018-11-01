<?php

namespace App\Repository;

use App\Entity\Subscription;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpFoundation\Response;

class SubscriptionRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Subscription::class);
    }

    /**
     * Todos los campos son obligatorios para el método POST
     */
    public function formPost($request)
    {
        if(isset($request['inDate']) && isset($request['outDate']) && isset($request['info']) && isset($request['price']) )
            return true;
        
        return $error = [
            'code'=>Response::HTTP_BAD_REQUEST,
            'message'=>'Values are invalid',
            'description'=>'The next fields are required {inDate[date], outDate[date], info[str], price[int]}'
        ];
    }

    /**
     * Algunos campos son obligatorios para le método PATH
     */
    public function formPatch($request)
    {
        if(isset($request['inDate']) || isset($request['outDate']) || isset($request['info']) || isset($request['price']) )
            return true;

        return $error = [
            'code'=>Response::HTTP_BAD_REQUEST,
            'message'=>'Values are invalid',
            'description'=>'Some of the next fields are required {inDate[date], outDate[date], info[str], price[int]}'
        ];
    }


    /**
     * Validar los campos pasadosen el request
     */
    public function formValidate($request)
    {
        $error = false;

        foreach($request as $key=>$value){
            switch($key){
                case 'inDate':
                case 'outDate':
                    $date = \DateTime::createFromFormat('Y-m-d', $value);
                    if(!$date || $date->format('Y-m-d') != $value)
                        $error = true;
                    break;
                case 'info':
                    if(empty($value))
                        $error = true;
                    break;
                case 'price':
                    if(!is_numeric($value)) 
                        $error = true;
                    break;
            }
        }

        if($error){
            return $error = [
                'code'=>Response::HTTP_BAD_REQUEST,
                'message'=>'Values are invalid',
                'description'=>'The next fields are required {inDate[date], outDate[date], info[str], price[int]}'
            ];
        }
        
        return true;
    }
}