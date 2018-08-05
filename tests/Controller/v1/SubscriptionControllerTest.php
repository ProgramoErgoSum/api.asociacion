<?php

namespace App\Tests\Controller\v1;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response; //https://api.symfony.com/4.1/Symfony/Component/HttpFoundation/Response.html

class SubscriotionControllerTest extends WebTestCase
{
    private $client = null;

    protected function setUp()
	{
        $this->client = static::createClient();
    }
    


    /**
     * @dataProvider provide_subscriptions_HTTP_UNAUTHORIZED
     */
    public function test_subscriptions_HTTP_UNAUTHORIZED($method = null, $url = null, $post = [])
    {
        $client = $this->client;
        $client->request($method, $url, $post);
        $response = $client->getResponse();
        $content = json_decode($response->getContent(), true);

        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
        $this->assertSame('application/json', $response->headers->get('content-type'));
        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $content['code']);
    }
    public function provide_subscriptions_HTTP_UNAUTHORIZED()
    {
        return [
            ['GET',     '/api/v1/partners/1/subscriptions',     []],
            ['GET',     '/api/v1/partners/1/subscriptions/1',   []],
            ['POST',    '/api/v1/partners/1/subscriptions',     []],
            ['PATCH',   '/api/v1/partners/1/subscriptions/1',   []],
            ['DELETE',  '/api/v1/partners/1/subscriptions/1',   []],
        ];
    }















    // ##################################################################################
    // ###################################   GET   ######################################
    // ##################################################################################


/* 
    public function test_GET_subscriptions_HTTP_OK()
    {
        $client = $this->client;
        $client->request('GET', '/api/v1/partners/1/subscriptions');
        $response = $client->getResponse();

        $this->assertTrue($response->isSuccessful());
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertSame('application/json', $response->headers->get('content-type'));

        $content = json_decode($response->getcontent(), true);
        $this->assertEquals('4', count($content));
    }

    public function test_GET_subscriptions_id_HTTP_OK()
    {
        $client = $this->client;
        $client->request('GET', '/api/v1/partners/1/subscriptions/1');
        $response = $client->getResponse();

        $this->assertTrue($response->isSuccessful());
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertSame('application/json', $response->headers->get('content-type'));

        $content = json_decode($response->getcontent(), true);
        $this->assertEquals('1', $content['id']);
    }

    /**
     * @dataProvider provide_test_GET_subscriptions_HTTP_BAD_REQUEST
     */
    /*
    public function test_GET_subscriptions_HTTP_BAD_REQUEST($url)
    {
        $client = $this->client;
        $client->request('GET', $url);
        $response = $client->getResponse();

        $this->assertFalse($response->isSuccessful());
        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        $this->assertSame('application/json', $response->headers->get('content-type'));
    }
    public function provide_test_GET_subscriptions_HTTP_BAD_REQUEST()
    {
        return array(
            array('/api/v1/partners/0/subscriptions'),
            array('/api/v1/partners/0/subscriptions/1'),
            array('/api/v1/partners/1/subscriptions/0'),
        );
    }



    // ##################################################################################
    // ##################################   POST   ######################################
    // ##################################################################################
    
    

    public function test_POST_subscriptions_HTTP_CREATED()
    {
        $client = $this->client;
        $post = array('inDate'=>'2018-08-02','outDate'=>'2019-08-02','info'=>'info','price'=>'1.1');
        $client->request('POST', '/api/v1/partners/1/subscriptions', $post);
        $response = $client->getResponse();

        $this->assertTrue($response->isSuccessful());
        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
        $this->assertSame('application/json', $response->headers->get('content-type'));

        $subscription = json_decode($response->getcontent(), true);

        // Una vez añadido se comprueba y se borra
        $client = static::createClient();
        $client->request('GET', '/api/v1/partners/1/subscriptions');
        $response = $client->getResponse();        
        $content = json_decode($response->getcontent(), true);
        $this->assertEquals('5', count($content));
    }

    /**
     * @dataProvider provide_POST_subscriptions_HTTP_BAD_REQUEST
     */
    /*
    public function test_POST_subscriptions_HTTP_BAD_REQUEST($data)
    {
        $client = $this->client;
        $client->request('POST', '/api/v1/partners/1/subscriptions', $data);
        $response = $client->getResponse();

        $this->assertFalse($response->isSuccessful());
        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        $this->assertSame('application/json', $response->headers->get('content-type'));
    }
    public function provide_POST_subscriptions_HTTP_BAD_REQUEST()
    {
        return array(
            array(array()),
            array(array(                 'outDate'=>'date','info'=>'info','price'=>'1')),
            array(array('inDate'=>'date'                  ,'info'=>'info','price'=>'1')),
            array(array('inDate'=>'date','outDate'=>'date'               ,'price'=>'1')),
            array(array('inDate'=>'date','outDate'=>'date','info'=>'info'             )),
            array(array('inDate'=>'date','outDate'=>'date','info'=>'info','price'=>'1')),
            
            array(array('inDate'=>'BAD','outDate'=>'2018-08-02','info'=>'info','price'=>'1')), // Notar fecha inválida
            array(array('inDate'=>'02-08-2018','outDate'=>'2018-08-02','info'=>'info','price'=>'1')), // Notar fecha inválida
            array(array('inDate'=>'2018-08-02 00:00:00','outDate'=>'2018-08-02','info'=>'info','price'=>'1')), // Notar fecha inválida
            array(array('inDate'=>'2018-08-02','outDate'=>'2019-08-02','info'=>'','price'=>'1')), // Notar info inválido
            array(array('inDate'=>'2018-08-02','outDate'=>'2019-08-02','info'=>'info','price'=>'BAD')), // Notar precio inválido
        );
    }



    // ##################################################################################
    // #################################   PATCH   ######################################
    // ##################################################################################



    /**
     * @dataProvider provide_PATCH_subscriptions_HTTP_CREATED
     */
    /*
    public function test_PATCH_subscriptions_HTTP_CREATED($data)
    {
        $client = $this->client;
        $client->request('PATCH', '/api/v1/partners/1/subscriptions/1', $data);
        $response = $client->getResponse();

        $this->assertTrue($response->isSuccessful());
        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
        $this->assertSame('application/json', $response->headers->get('content-type'));
    }
    public function provide_PATCH_subscriptions_HTTP_CREATED()
    {
        return array(
            array(array('inDate'=>'2019-08-02')),
            array(array('outDate'=>'2020-08-02')),
            array(array('info'=>'nueva info')),
            array(array('price'=>'1.2')),

            array(array('inDate'=>'2015-01-01')), // Para restaurar
            array(array('outDate'=>'2016-01-01')),
            array(array('info'=>'Suscripción 1')),
            array(array('price'=>'1.11')),
        );
    }

    /**
     * @dataProvider provide_PATCH_subscriptions_HTTP_BAD_REQUEST
     */
    /*
    public function test_PATCH_subscriptions_HTTP_BAD_REQUEST($data)
    {
        $client = $this->client;
        $client->request('PATCH', '/api/v1/partners/1/subscriptions/1', $data);
        $response = $client->getResponse();

        $this->assertFalse($response->isSuccessful());
        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        $this->assertSame('application/json', $response->headers->get('content-type'));
    }
    public function provide_PATCH_subscriptions_HTTP_BAD_REQUEST()
    {
        return array(
            array(array()),
            array(array('inDate'=>'')),
            array(array('inDate'=>'BAD')),
            array(array('outDate'=>'BAD')),
            array(array('info'=>'')),
            array(array('price'=>'a')),
            array(array('price'=>'1,5')), // Notar la coma (,) debe ser punto
        );
    }



    // ##################################################################################
    // ################################   DELETE   ######################################
    // ##################################################################################


    public function test_DELETE_subscriptions_HTTP_ACCEPTED()
    {
        $client = $this->client;
        $client->request('DELETE', '/api/v1/partners/1/subscriptions/1');
        $response = $client->getResponse();

        $this->assertTrue($response->isSuccessful());
        $this->assertEquals(Response::HTTP_ACCEPTED, $response->getStatusCode());
        $this->assertSame('application/json', $response->headers->get('content-type'));
    }
    */
}