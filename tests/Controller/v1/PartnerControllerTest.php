<?php

namespace App\Tests\Controller\v1;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

//https://api.symfony.com/4.1/Symfony/Component/HttpFoundation/Response.html

class PartnerControllerTest extends WebTestCase
{
    private $client = null;

    protected function setUp()
	{
        $this->client = static::createClient();
    }
    

    
    /**
     * @dataProvider provide_urls_HTTP_OK
     */
    public function test_url_HTTP_OK($url)
    {
        $client = $this->client;
        $client->request('GET', $url);
        $response = $client->getResponse();

        $this->assertTrue($response->isSuccessful());
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertSame('application/json', $response->headers->get('content-type'));
    }
    public function provide_urls_HTTP_OK()
    {
        return array(
            array('/api/v1/partners'),
            array('/api/v1/partners/1'),
            array('/api/v1/partners/1/subscriptions'),
            array('/api/v1/partners/1/subscriptions/1'),
        );
    }

    /**
     * @dataProvider provide_urls_HTTP_BAD_REQUEST
     */
    public function test_url_is_HTTP_BAD_REQUEST($url)
    {
        $client = $this->client;
        $client->request('GET', $url);
        $response = $client->getResponse();

        $this->assertFalse($response->isSuccessful());
        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        $this->assertSame('application/json', $response->headers->get('content-type'));
    }
    public function provide_urls_HTTP_BAD_REQUEST()
    {
        return array(
            array('/api/v1/partners/0'),
            array('/api/v1/partners/0/subscriptions'),
            array('/api/v1/partners/0/subscriptions/1'),
            array('/api/v1/partners/1/subscriptions/0'),
        );
    }



    /**
     * @dataProvider provide_post_partners_HTTP_CREATED
     */
    public function test_post_partners_HTTP_CREATED($data)
    {
        $client = $this->client;
        $client->request('POST', '/api/v1/partners', $data);
        $response = $client->getResponse();

        $this->assertTrue($response->isSuccessful());
        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
        $this->assertSame('application/json', $response->headers->get('content-type'));
    }
    public function provide_post_partners_HTTP_CREATED()
    {
        return array(
            array(array('name'=>'name','surname'=>'surname','email'=>'email@email.com','active'=>'1','role'=>'1')),
        );
    }

    /**
     * @dataProvider provide_post_partners_HTTP_BAD_REQUEST
     */
    public function test_post_partners_HTTP_BAD_REQUEST($data)
    {
        $client = $this->client;
        $client->request('POST', '/api/v1/partners', $data);
        $response = $client->getResponse();

        $this->assertFalse($response->isSuccessful());
        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        $this->assertSame('application/json', $response->headers->get('content-type'));
    }
    public function provide_post_partners_HTTP_BAD_REQUEST()
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

    /**
     * @dataProvider provide_patch_partners_HTTP_CREATED
     */
    public function test_patch_partners_HTTP_CREATED($data)
    {
        $client = $this->client;
        $client->request('PATCH', '/api/v1/partners/1', $data);
        $response = $client->getResponse();

        $this->assertTrue($response->isSuccessful());
        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
        $this->assertSame('application/json', $response->headers->get('content-type'));
    }
    public function provide_patch_partners_HTTP_CREATED()
    {
        return array(
            array(array('name'=>'nuevo nombre')),
            array(array('surname'=>'nuevo surname')),
            array(array('email'=>'nuevo@email.com')),
            array(array('password'=>'nuevo password')),
            array(array('active'=>'0')),
            array(array('role'=>'0')),
        );
    }

    /**
     * @dataProvider provide_patch_partners_HTTP_BAD_REQUEST
     */
    public function test_patch_partners_HTTP_BAD_REQUEST($data)
    {
        $client = $this->client;
        $client->request('PATCH', '/api/v1/partners/1', $data);
        $response = $client->getResponse();

        $this->assertFalse($response->isSuccessful());
        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        $this->assertSame('application/json', $response->headers->get('content-type'));
    }
    public function provide_patch_partners_HTTP_BAD_REQUEST()
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

    

    

    /**
     * @dataProvider provide_post_partners_subscriptions_HTTP_CREATED
     */
    public function test_post_partners_subscriptions_HTTP_CREATED($data)
    {
        $client = $this->client;
        $client->request('POST', '/api/v1/partners/1/subscriptions', $data);
        $response = $client->getResponse();

        $this->assertTrue($response->isSuccessful());
        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
        $this->assertSame('application/json', $response->headers->get('content-type'));
    }
    public function provide_post_partners_subscriptions_HTTP_CREATED()
    {
        return array(
            array(array('inDate'=>'2018-08-02','outDate'=>'2019-08-02','info'=>'info','price'=>'1')),
            array(array('inDate'=>'2018-08-02','outDate'=>'2019-08-02','info'=>'info','price'=>'1.1')),
        );
    }

    /**
     * @dataProvider provide_post_partners_subscriptions_HTTP_BAD_REQUEST
     */
    public function test_post_partners_subscriptions_HTTP_BAD_REQUEST($data)
    {
        $client = $this->client;
        $client->request('POST', '/api/v1/partners/1/subscriptions', $data);
        $response = $client->getResponse();

        $this->assertFalse($response->isSuccessful());
        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        $this->assertSame('application/json', $response->headers->get('content-type'));
    }
    public function provide_post_partners_subscriptions_HTTP_BAD_REQUEST()
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
}