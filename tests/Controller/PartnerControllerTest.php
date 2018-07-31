<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

//https://api.symfony.com/4.1/Symfony/Component/HttpFoundation/Response.html

class PartnerControllerTest extends WebTestCase
{
    protected function setUp()
	{

    }
    
    public function testGetPartners()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/api/v1/partners');

        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        $this->assertSame('application/json', $client->getResponse()->headers->get('content-type'));
    }

    public function testGetPartner_NO_CONTENT()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/api/v1/partners/BAD_SALT');

        $this->assertEquals(Response::HTTP_NO_CONTENT, $client->getResponse()->getStatusCode());
    }

    public function testGetPartner_OK()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/api/v1/partners/b2ede222a18710041d55d606b3c49573');

        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        $this->assertSame('application/json', $client->getResponse()->headers->get('content-type'));
    }

    public function testGetPartnerSubscription_NO_CONTENT()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/api/v1/partners/BAD_SALT/subscriptions');

        $this->assertEquals(Response::HTTP_NO_CONTENT, $client->getResponse()->getStatusCode());
    }

    public function testGetPartnerSubscription_OK()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/api/v1/partners/b2ede222a18710041d55d606b3c49573/subscriptions');

        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        $this->assertSame('application/json', $client->getResponse()->headers->get('content-type'));
    }
}