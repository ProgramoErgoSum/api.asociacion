<?php

namespace App\Controller;

use App\Entity\Partner;

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
     * Lists all Partners.
     * 
     * @Route("/partners", methods={"GET"})
     */    
    public function getPartners(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $partners = $em->getRepository(Partner::class)->findAll();
                
        return View::create($partners, Response::HTTP_OK , []);   
    }
}