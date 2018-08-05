<?php

namespace App\Tests\Controller\v1;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response; //https://api.symfony.com/4.1/Symfony/Component/HttpFoundation/Response.html

class PartnerControllerTest extends WebTestCase
{
    private $client = null;

    protected function setUp()
	{
        $this->client = static::createClient();
    }



    /**
     * @dataProvider provide_partners_HTTP_UNAUTHORIZED
     */
    public function test_partners_HTTP_UNAUTHORIZED($method = null, $url = null, $post = [])
    {
        $client = $this->client;
        $client->request($method, $url, $post);
        $response = $client->getResponse();
        $content = json_decode($response->getContent(), true);

        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
        $this->assertSame('application/json', $response->headers->get('content-type'));
        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $content['code']);
    }
    public function provide_partners_HTTP_UNAUTHORIZED()
    {
        return [
            ['GET',     '/api/v1/partners',     []],
            ['GET',     '/api/v1/partners/1',   []],
            ['POST',    '/api/v1/partners',     []],
            ['PATCH',   '/api/v1/partners/1',   []],
            ['DELETE',  '/api/v1/partners/1',   []],
        ];
    }


















    
    // ##################################################################################
    // ###################################   GET   ######################################
    // ##################################################################################


    /*
    public function test_GET_partners_HTTP_OK()
    {
        $client = $this->client;
        $client->request('GET', '/api/v1/partners');
        $response = $client->getResponse();

        $this->assertTrue($response->isSuccessful());
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertSame('application/json', $response->headers->get('content-type'));
        
        $content = json_decode($response->getcontent(), true);
        $this->assertEquals('4', count($content));
    }

    public function test_GET_partners_id_HTTP_OK()
    {
        $client = $this->client;
        $client->request('GET', '/api/v1/partners/1');
        $response = $client->getResponse();

        $this->assertTrue($response->isSuccessful());
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertSame('application/json', $response->headers->get('content-type'));
        
        $content = json_decode($response->getcontent(), true);
        $this->assertEquals('1', $content['id']);
    }

    public function test_GET_partners_id_HTTP_BAD_REQUEST()
    {
        $client = $this->client;
        $client->request('GET', '/api/v1/partners/0');
        $response = $client->getResponse();

        $this->assertFalse($response->isSuccessful());
        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        $this->assertSame('application/json', $response->headers->get('content-type'));

        $content = json_decode($response->getcontent(), true);
        $this->assertEquals(Response::HTTP_BAD_REQUEST, $content['code']);
    }



    // ##################################################################################
    // ##################################   POST   ######################################
    // ##################################################################################


/*
    public function test_POST_partners_HTTP_CREATED()
    {
        $client = $this->client;
        $post = array('name'=>'name','surname'=>'surname','email'=>'email@email.com','active'=>'1','role'=>'1');
        $client->request('POST', '/api/v1/partners', $post);
        $response = $client->getResponse();

        $this->assertTrue($response->isSuccessful());
        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
        $this->assertSame('application/json', $response->headers->get('content-type'));

        $partner = json_decode($response->getcontent(), true);

        // Una vez añadido se comprueba y se borra
        $client = static::createClient();
        $client->request('GET', '/api/v1/partners');
        $response = $client->getResponse();        
        $content = json_decode($response->getcontent(), true);
        $this->assertEquals('5', count($content));

        $client = static::createClient();
        $client->request('GET', '/api/v1/partners/'.$partner['id']);
        $response = $client->getResponse();        
        $content = json_decode($response->getcontent(), true);
        $this->assertEquals($partner['id'], $content['id']);

        $client = static::createClient();
        $client->request('DELETE', '/api/v1/partners/'.$partner['id']);
        $response = $client->getResponse();        
        $content = json_decode($response->getcontent(), true);
        $this->assertEquals(Response::HTTP_ACCEPTED, $response->getStatusCode());
    }

    /**
     * @dataProvider provide_POST_partners_HTTP_BAD_REQUEST
     */
    /*
    public function test_POST_partners_HTTP_BAD_REQUEST($data)
    {
        $client = $this->client;
        $client->request('POST', '/api/v1/partners', $data);
        $response = $client->getResponse();

        $this->assertFalse($response->isSuccessful());
        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        $this->assertSame('application/json', $response->headers->get('content-type'));
    }
    public function provide_POST_partners_HTTP_BAD_REQUEST()
    {
        return array(
            array(array()),
            array(array(               'surname'=>'surname','email'=>'email','active'=>'1','role'=>'1')),
            array(array('name'=>'name'                     ,'email'=>'email','active'=>'1','role'=>'1')),
            array(array('name'=>'name','surname'=>'surname'                 ,'active'=>'1','role'=>'1')),
            array(array('name'=>'name','surname'=>'surname','email'=>'email'              ,'role'=>'1')),
            array(array('name'=>'name','surname'=>'surname','email'=>'email','active'=>'1'            )),
            
            array(array('name'=>'','surname'=>'surname','email'=>'email','active'=>'1','role'=>'1')), // Notar name inválido
            array(array('name'=>'name','surname'=>'','email'=>'email','active'=>'1','role'=>'1')), // Notar surname inválido
            array(array('name'=>'name','surname'=>'surname','email'=>'email','active'=>'1','role'=>'1')), // Notar que el email no es válido (@.)
            array(array('name'=>'name','surname'=>'surname','email'=>'e@e.e','active'=>'a','role'=>'1')), // Notar que active no es válido
            array(array('name'=>'name','surname'=>'surname','email'=>'e@e.e','active'=>'1','role'=>'a')), // Notar que role no es válido
            array(array('name'=>'name','surname'=>'surname','email'=>'email1@email.com','active'=>'1','role'=>'1')), // Notar que el email ya existe
        );
    }



    // ##################################################################################
    // #################################   PATCH   ######################################
    // ##################################################################################



    /**
     * @dataProvider provide_PATCH_partners_HTTP_CREATED
     */
    /*
    public function test_PATCH_partners_HTTP_CREATED($data)
    {
        $client = $this->client;
        $client->request('PATCH', '/api/v1/partners/1', $data);
        $response = $client->getResponse();

        $this->assertTrue($response->isSuccessful());
        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
        $this->assertSame('application/json', $response->headers->get('content-type'));
    }
    public function provide_PATCH_partners_HTTP_CREATED()
    {
        return array(
            array(array('name'=>'nuevo nombre')),
            array(array('surname'=>'nuevo surname')),
            array(array('email'=>'nuevo@email.com')),
            array(array('password'=>'nuevo password')),
            array(array('active'=>'0')),
            array(array('role'=>'0')),

            array(array('name'=>'Name 1')), // Para restaurar como estaba
            array(array('surname'=>'Surname 1')),
            array(array('email'=>'email1@email.com')),
            array(array('password'=>'password')),
            array(array('active'=>'1')),
            array(array('role'=>'1')),
        );
    }

    /**
     * @dataProvider provide_PATCH_partners_HTTP_BAD_REQUEST
     */
    /*
    public function test_PATCH_partners_HTTP_BAD_REQUEST($data)
    {
        $client = $this->client;
        $client->request('PATCH', '/api/v1/partners/1', $data);
        $response = $client->getResponse();

        $this->assertFalse($response->isSuccessful());
        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        $this->assertSame('application/json', $response->headers->get('content-type'));
    }
    public function provide_PATCH_partners_HTTP_BAD_REQUEST()
    {
        return array(
            array(array()),
            array(array('name'=>'')),
            array(array('surname'=>'')),
            array(array('email'=>'email no válido')),
            array(array('password'=>'')),
            array(array('active'=>'a')),
            array(array('role'=>'a')),
        );
    }



    // ##################################################################################
    // ################################   DELETE   ######################################
    // ##################################################################################



    public function test_DELETE_partners_HTTP_PARTIAL_CONTENT()
    {
        $client = $this->client;
        $client->request('DELETE', '/api/v1/partners/1');
        $response = $client->getResponse();

        $this->assertTrue($response->isSuccessful());
        $this->assertEquals(Response::HTTP_PARTIAL_CONTENT, $response->getStatusCode());
        $this->assertSame('application/json', $response->headers->get('content-type'));
    }

    /*
    public function test_DELETE_partners_HTTP_ACCEPTED()
    {
        $client = $this->client;
        $client->request('DELETE', '/api/v1/partners/3');
        $response = $client->getResponse();

        $this->assertTrue($response->isSuccessful());
        $this->assertEquals(Response::HTTP_ACCEPTED, $response->getStatusCode());
        $this->assertSame('application/json', $response->headers->get('content-type'));
    }
    */

}