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
     * @param Request $request
     */    
    public function getPartners(Request $request): View
    {
        $em = $this->getDoctrine()->getManager();

        $partners = $em->getRepository(Partner::class)->findAll();
                
        return View::create($partners, Response::HTTP_OK , []);   
    }

    /**
     * @Route("/partners/{id_partner}", methods={"GET"})
     * @param Request $request
     * @param string $id_partner
     */    
    public function getPartner(Request $request, $id_partner = null): View
    {
        $em = $this->getDoctrine()->getManager();

        $partner = $em->getRepository(Partner::class)->findOneBy(array("id"=>$id_partner));

        if($partner == null)
            return View::create($partner, Response::HTTP_NO_CONTENT , []); 
                
        return View::create($partner, Response::HTTP_OK , []);   
    }

    /**
     * @Route("/partners/{id_partner}/subscriptions", methods={"GET"})
     * @param Request $request
     * @param string $id_partner
     */    
    public function getPartnerSubscription(Request $request, $id_partner = null): View
    {
        $em = $this->getDoctrine()->getManager();

        $partner = $em->getRepository(Partner::class)->findOneBy(array("id"=>$id_partner));

        if($partner == null)
            return View::create($partner, Response::HTTP_NO_CONTENT , []); 
       
        return View::create($partner->getSubscriptions(), Response::HTTP_OK , []);   
    }

    /**
     * @Route("/partners/{id_partner}/subscriptions/{id_subscription}", methods={"GET"})
     * @param Request $request
     * @param string $id_partner
     * @param string $id_subscription
     */    
    public function getPartnerSubscriptionById(Request $request, $id_partner = null, $id_subscription = null): View
    {
        $em = $this->getDoctrine()->getManager();

        $partner = $em->getRepository(Partner::class)->findOneBy(array("id"=>$id_partner));

        if($partner == null)
            return View::create($partner, Response::HTTP_NO_CONTENT , []);
            
        $subscriptions = $em->getRepository(Subscription::class)->findBy(array("partner"=>$partner->getId(), 'id'=>$id_subscription));

        if($subscriptions == null)
            return View::create($partner, Response::HTTP_NO_CONTENT , []); 

        return View::create($subscriptions, Response::HTTP_OK , []);   
    }
}