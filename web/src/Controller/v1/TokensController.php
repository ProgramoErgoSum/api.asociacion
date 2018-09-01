<?php

namespace App\Controller\v1;

use App\Entity\Admin;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use FOS\RestBundle\View\View;

/**
 * Tokens controller.
 *
 * @Route("/api/v1")
 */
class TokensController extends Controller
{
    /**
     * @Route("/tokens", methods={"POST"})
     */
    public function postTokens(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $admin = $em->getRepository(Admin::class)->findOneBy(['username'=>$request->get('_username')]);
        if($admin === null || !$this->get('security.password_encoder')->isPasswordValid($admin, $request->get('_password'))){
            $error = [
                'code'=>Response::HTTP_BAD_REQUEST,
                'message'=>'Invalid credentials',
                'description'=>'Invalid credentials'
            ];
            return View::create($error, Response::HTTP_BAD_REQUEST); 
        }
        
        $json = [
            'code'=>Response::HTTP_OK,
            'message'=>'Token for user',
            'token'=>$this->get('lexik_jwt_authentication.encoder')->encode(['username' => $admin->getUsername()])
        ];
        return View::create($json, Response::HTTP_OK); 
    }
}