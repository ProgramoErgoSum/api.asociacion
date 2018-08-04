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
 * Subscription controller.
 *
 * @Route("/api/v1")
 */
class SubscriptionController extends Controller
{
    /**
     * @Route("/partners/{id_partner}/subscriptions", methods={"GET"})
     * @param string $id_partner
     */    
    public function getSubscriptions($id_partner = null): View
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
     * @Route("/partners/{id_partner}/subscriptions", methods={"POST"})
     * @param Request $request
     */    
    public function postSubscriptions(Request $request): View
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository(Subscription::class);

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
        
        $subscription = new Subscription();
        $subscription->setInDate(new \DateTime($request->get('inDate')));
        $subscription->setOutDate(new \DateTime($request->get('outDate')));
        $subscription->setInfo($request->get('info'));
        $subscription->setPrice($request->get('price'));
        //$subscription->setCDate(new \DateTime('now'));
        //$subscription->setMDate(new \DateTime('0000-00-00 00:00:00'));
        $em->persist($subscription);
        //$em->flush();
        
        return View::create($subscription, Response::HTTP_CREATED);  
    }



    /**
     * @Route("/partners/{id_partner}/subscriptions/{id_subscription}", methods={"GET"})
     * @param string $id_partner
     * @param string $id_subscription
     */    
    public function getSubscriptionsId($id_partner = null, $id_subscription = null): View
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

    /**
     * @Route("/partners/{id_partner}/subscriptions/{id_subscription}", methods={"PATCH"})
     * @param Request $request
     * @param string $id_partner
     * @param string $id_subscription
     */    
    public function patchSubscriptionsId(Request $request, $id_partner = null, $id_subscription = null): View
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository(Subscription::class);

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

        if($request->get('inDate'))
            $subscription->setInDate(new \DateTime($request->get('inDate')));

        if($request->get('outDate'))
            $subscription->setOutDate(new \DateTime($request->get('outDate')));

        if($request->get('info'))
            $subscription->setInfo($request->get('info'));

        if($request->get('price'))
            $subscription->setPrice($request->get('price'));

        //$subscription->setMDate(new \DateTime('now'));
        $em->persist($subscription);
        //$em->flush();
        
        return View::create($subscription, Response::HTTP_CREATED);  
    }

    /**
     * @Route("/partners/{id_partner}/subscriptions/{id_subscription}", methods={"DELETE"})
     * @param string $id_partner
     * @param string $id_subscription
     */    
    public function deletePartnersId($id_partner = null, $id_subscription = null): View
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository(Partner::class);

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

        $em->remove($partner);
        //$em->flush();
        
        return View::create(null, Response::HTTP_ACCEPTED);  
    }
}