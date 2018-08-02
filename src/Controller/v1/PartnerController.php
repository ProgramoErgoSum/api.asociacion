<?php

namespace App\Controller\v1;

use App\Entity\Partner;
use App\Form\PartnerType;
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
     * @Route("/partners", methods={"POST"})
     * @param Request $request
     */    
    public function postPartners(Request $request): View
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository(Partner::class);

        if(!$repo->formValidate($request->request->all())){
            $error = [
                'code'=>Response::HTTP_BAD_REQUEST,
                'message'=>'Values are invalid',
                'description'=>'The next fields are required {name[str], surname[str], email[email], active[int], role[int]}'
            ];
            return View::create($error, Response::HTTP_BAD_REQUEST); 
        }

        $exist_email = $em->getRepository('App:Partner')->findOneBy(array('email'=>$request->get('email')));
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
            $exist_code = $em->getRepository('App:Partner')->findOneBy(array('code'=>$code));
        } while ($exist_code!=null);
        $partner->setCode($code);
        $partner->setSalt(md5(uniqid()));
        $partner->setPassword(password_hash($partner->getCode(), PASSWORD_BCRYPT, array('cost' => 4)));

        $em->persist($partner);
        //$em->flush();
        
        return View::create($partner, Response::HTTP_CREATED);  
    }



    /**
     * @Route("/partners/{id_partner}", methods={"GET"})
     * @param string $id_partner
     */    
    public function getPartnersId($id_partner = null): View
    {
        $em = $this->getDoctrine()->getManager();

        $partner = $em->getRepository(Partner::class)->findOneBy(array('id'=>$id_partner));
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
     * @Route("/partners/{id_partner}/subscriptions", methods={"GET"})
     * @param string $id_partner
     */    
    public function getPartnersIdSubscriptions($id_partner = null): View
    {
        $em = $this->getDoctrine()->getManager();

        $partner = $em->getRepository(Partner::class)->findOneBy(array('id'=>$id_partner));
        if($partner === null){
            $error = [
                'code'=>Response::HTTP_BAD_REQUEST,
                'message'=>'Not found',
                'description'=>'The partner not exist'
            ];
            return View::create($error, Response::HTTP_BAD_REQUEST); 
        }
       
        return View::create($partner->getSubscriptions(), Response::HTTP_OK);   
    }



    /**
     * @Route("/partners/{id_partner}/subscriptions/{id_subscription}", methods={"GET"})
     * @param string $id_partner
     * @param string $id_subscription
     */    
    public function getPartnersIdSubscriptionsId($id_partner = null, $id_subscription = null): View
    {
        $em = $this->getDoctrine()->getManager();

        $partner = $em->getRepository(Partner::class)->findOneBy(array('id'=>$id_partner));
        if($partner === null){
            $error = [
                'code'=>Response::HTTP_BAD_REQUEST,
                'message'=>'Not found',
                'description'=>'The partner not exist'
            ];
            return View::create($error, Response::HTTP_BAD_REQUEST); 
        }
            
        $subscription = $em->getRepository(Subscription::class)->findOneBy(array('partner'=>$partner->getId(), 'id'=>$id_subscription));
        if($subscription === null){
            $error = [
                'code'=>Response::HTTP_BAD_REQUEST,
                'message'=>'Not found',
                'description'=>'The subscription not exist'
            ];
            return View::create($error, Response::HTTP_BAD_REQUEST); 
        }

        return View::create($subscription, Response::HTTP_OK);   
    }
}