<?php

namespace App\Repository;

use App\Entity\Partner;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpFoundation\Response;

class PartnerRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Partner::class);
    }

    /**
     * Todos los campos son obligatorios para el método POST
     */
    public function formPost($request)
    {
        if(isset($request['name']) && isset($request['surname']) && isset($request['email']) && isset($request['active']) && isset($request['role']))
            return true;
        
        return $error = [
            'code'=>Response::HTTP_BAD_REQUEST,
            'message'=>'Values are invalid',
            'description'=>'The next fields are required {name[str], surname[str], email[email], active[int], role[int]}'
        ];
    }

    /**
     * Algunos campos son obligatorios para le método PATH
     */
    public function formPatch($request)
    {
        if(isset($request['name']) || isset($request['surname']) || isset($request['email']) || isset($request['password']) || isset($request['active']) || isset($request['role']))
            return true;

        return $error = [
            'code'=>Response::HTTP_BAD_REQUEST,
            'message'=>'Values are invalid',
            'description'=>'Some of the next fields are required {name[str], surname[str], email[email], password[str], active[int], role[int]}'
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
                case 'name':
                case 'surname':
                case 'password':
                    if(empty($value))
                        $error = true;
                    break;
                case 'email':
                    if(!strpos($value, "@") || !strpos($value, ".")) 
                        $error = true;
                    break;
                case 'active':
                case 'role':
                    if(!is_numeric($value)) 
                        $error = true;
                    break;
            }
        }

        if($error){
            return $error = [
                'code'=>Response::HTTP_BAD_REQUEST,
                'message'=>'Values are invalid',
                'description'=>'The next fields are required {name[str], surname[str], email[email], active[int], role[int]}'
            ];
        }
        
        return true;
    }
}
