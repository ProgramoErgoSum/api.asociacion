<?php

namespace App\Controller;

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
     * @Route("/partners/{salt}", methods={"GET"})
     * @param Request $request
     * @param string $salt
     */    
    public function getPartner(Request $request, $salt = null): View
    {
        $em = $this->getDoctrine()->getManager();

        $partner = $em->getRepository(Partner::class)->findOneBy(array("salt"=>$salt));

        if($partner == null)
            return View::create($partner, Response::HTTP_NO_CONTENT , []); 
                
        return View::create($partner, Response::HTTP_OK , []);   
    }

    /**
     * @Route("/partners/{salt}/subscriptions", methods={"GET"})
     * @param Request $request
     * @param string $salt
     */    
    public function getPartnerSubscription(Request $request, $salt = null): View
    {
        $em = $this->getDoctrine()->getManager();

        $partner = $em->getRepository(Partner::class)->findOneBy(array("salt"=>$salt));

        if($partner == null)
            return View::create($partner, Response::HTTP_NO_CONTENT , []); 

        $subscriptions = $em->getRepository(Subscription::class)->findBy(array("partner"=>$partner->getId()), array("inDate"=>"ASC"));
                
        return View::create($subscriptions, Response::HTTP_OK , []);   
    }
}