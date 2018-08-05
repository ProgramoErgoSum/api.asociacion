<?php

namespace App\Controller\v1;

use App\Entity\Partner;
use App\Entity\Subscription;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use FOS\RestBundle\View\View;

/**
 * Partner controller.
 *
 * @Route("/api/v1")
 */
class PartnerController extends Controller
{
    /**
     * @Route("/partners", methods={"GET"})
     */    
    public function getPartners(): View
    {
        $em = $this->getDoctrine()->getManager();

        $partners = $em->getRepository(Partner::class)->findAll();
                
        return View::create($partners, Response::HTTP_OK);   
    }

    /**
     * @Route("/partners/{id_partner}", methods={"GET"})
     * @param string $id_partner
     */    
    public function getPartnersId($id_partner = null): View
    {
        $em = $this->getDoctrine()->getManager();

        $partner = $em->getRepository(Partner::class)->findOneBy(['id'=>$id_partner]);
        if($partner === null){
            $error = [
                'code'=>Response::HTTP_BAD_REQUEST,
                'message'=>'Not found',
                'description'=>'The partner not exist'
            ];
            return View::create($error, Response::HTTP_BAD_REQUEST); 
        }
                
        return View::create($partner, Response::HTTP_OK);   
    }

    /**
     * @Route("/partners", methods={"POST"})
     * @param Request $request
     */    
    public function postPartners(Request $request): View
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository(Partner::class);

        // Todos los campos requeridos
        $error = $repo->formPost($request->request->all());
        if(is_array($error)){
            return View::create($error, Response::HTTP_BAD_REQUEST); 
        }

        // Todos los campos válidos
        $error = $repo->formValidate($request->request->all());
        if(is_array($error)){
            return View::create($error, Response::HTTP_BAD_REQUEST); 
        }

        // Email no existe
        $exist_email = $em->getRepository('App:Partner')->findOneBy(['email'=>$request->get('email')]);
        if($exist_email !== null){
            $error = [
                'code'=>Response::HTTP_BAD_REQUEST,
                'message'=>'Email already exist',
                'description'=>'The email already exist en db'
            ];
            return View::create($error, Response::HTTP_BAD_REQUEST); 
        }
        
        $partner = new Partner();
        $partner->setName($request->get('name'));
        $partner->setSurname($request->get('surname'));
        $partner->setEmail($request->get('email'));
        $partner->setActive($request->get('active'));
        $partner->setRole($request->get('role'));
        do {
            $code = substr(str_shuffle(str_repeat('BCDEFGHIJKLMNOPQRSTUVWXYZ0123456789', 6)), 0, 6);
            $exist_code = $em->getRepository('App:Partner')->findOneBy(['code'=>$code]);
        } while ($exist_code!=null);
        $partner->setCode($code);
        $partner->setSalt(md5(uniqid()));
        $partner->setPassword(password_hash($partner->getCode(), PASSWORD_BCRYPT, ['cost' => 4]));
        $partner->setCDate(new \DateTime('now'));
        $partner->setMDate(new \DateTime('now'));
        $em->persist($partner);
        $em->flush();
        
        $partners = $em->getRepository(Partner::class)->findAll();
        return View::create($partners, Response::HTTP_CREATED);  
    }
    
    /**
     * @Route("/partners/{id_partner}", methods={"PATCH"})
     * @param Request $request
     * @param string $id_partner
     */    
    public function patchPartnersId(Request $request, $id_partner = null): View
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository(Partner::class);

        $partner = $em->getRepository(Partner::class)->findOneBy(['id'=>$id_partner]);
        if($partner === null){
            $error = [
                'code'=>Response::HTTP_BAD_REQUEST,
                'message'=>'Not found',
                'description'=>'The partner not exist'
            ];
            return View::create($error, Response::HTTP_BAD_REQUEST); 
        }

        // Algunos campos requeridos
        $error = $repo->formPatch($request->request->all());
        if(is_array($error)){
            return View::create($error, Response::HTTP_BAD_REQUEST); 
        }

        // Todos los campos válidos
        $error = $repo->formValidate($request->request->all());
        if(is_array($error)){
            return View::create($error, Response::HTTP_BAD_REQUEST); 
        }

        // Email no existe
        $exist_email = $em->getRepository('App:Partner')->findOneBy(['email'=>$request->get('email')]);
        if($exist_email !== null){
            $error = [
                'code'=>Response::HTTP_BAD_REQUEST,
                'message'=>'Email already exist',
                'description'=>'The email already exist en db'
            ];
            return View::create($error, Response::HTTP_BAD_REQUEST); 
        }

        if($request->get('name')!== null)
            $partner->setName($request->get('name'));

        if($request->get('surname')!== null)
            $partner->setSurname($request->get('surname'));

        if($request->get('email')!== null)
            $partner->setEmail($request->get('email'));

        if($request->get('active')!== null)
            $partner->setActive($request->get('active'));

        if($request->get('role')!== null)
            $partner->setRole($request->get('role'));
        
        if($request->get('password')!== null)
            $partner->setPassword(password_hash($partner->getCode(), PASSWORD_BCRYPT, ['cost' => 4]));

        $partner->setMDate(new \DateTime('now'));
        $em->persist($partner);
        $em->flush();
        
        return View::create($partner, Response::HTTP_CREATED);  
    }

    /**
     * @Route("/partners/{id_partner}", methods={"DELETE"})
     * @param string $id_partner
     */    
    public function deletePartnersId($id_partner = null): View
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository(Partner::class);

        $partner = $em->getRepository(Partner::class)->findOneBy(['id'=>$id_partner]);
        if($partner === null){
            $error = [
                'code'=>Response::HTTP_BAD_REQUEST,
                'message'=>'Not found',
                'description'=>'The partner not exist'
            ];
            return View::create($error, Response::HTTP_BAD_REQUEST); 
        }

        // Comprobar si tiene subscripciones
        $subscriptions = $em->getRepository(Subscription::class)->findOneBy(['partner'=>$partner->getId()]);
        if($subscriptions){
            $error = [
                'code'=>Response::HTTP_PARTIAL_CONTENT,
                'message'=>'Partner with subscriptions',
                'description'=>'This partner has subscriptions'
            ];
            return View::create($error, Response::HTTP_PARTIAL_CONTENT); 
        }

        $em->remove($partner);
        $em->flush();
        
        return View::create(null, Response::HTTP_ACCEPTED);  
    }

}