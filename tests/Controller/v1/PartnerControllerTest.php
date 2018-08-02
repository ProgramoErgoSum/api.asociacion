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
     * @dataProvider provide_data_HTTP_CREATED
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
    public function provide_data_HTTP_CREATED()
    {
        return array(
            array(array('name'=>'name','surname'=>'surname','email'=>'email@email.com','active'=>'1','role'=>'1')),
        );
    }

    /**
     * @dataProvider provide_data_HTTP_BAD_REQUEST
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
    public function provide_data_HTTP_BAD_REQUEST()
    {
        return array(
            array(array()),
            array(array(               'surname'=>'surname','email'=>'email','active'=>'1','role'=>'1')),
            array(array('name'=>'name'                     ,'email'=>'email','active'=>'1','role'=>'1')),
            array(array('name'=>'name','surname'=>'surname'                 ,'active'=>'1','role'=>'1')),
            array(array('name'=>'name','surname'=>'surname','email'=>'email'              ,'role'=>'1')),
            array(array('name'=>'name','surname'=>'surname','email'=>'email','active'=>'1'            )),
            
            array(array('name'=>'name','surname'=>'surname','email'=>'email','active'=>'1','role'=>'1')), // Notar que el email no es válido (@.)
            array(array('name'=>'name','surname'=>'surname','email'=>'e@e.e','active'=>'a','role'=>'1')), // Notar que active no es válido
            array(array('name'=>'name','surname'=>'surname','email'=>'e@e.e','active'=>'1','role'=>'a')), // Notar que role no es válido
            array(array('name'=>'name','surname'=>'surname','email'=>'email1@email.com','active'=>'1','role'=>'1')), // Notar que el email ya existe
        );
    }
}