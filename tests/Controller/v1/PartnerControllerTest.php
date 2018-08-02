<?php

namespace App\Tests\Controller\v1;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

//https://api.symfony.com/4.1/Symfony/Component/HttpFoundation/Response.html

class PartnerControllerTest extends WebTestCase
{
    protected function setUp()
	{

    }
    
    /**
     * @dataProvider provide_urls_ok
     */
    public function test_url_is_ok($url)
    {
        $client = static::createClient();
        $client->request('GET', $url);

        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        $this->assertSame('application/json', $client->getResponse()->headers->get('content-type'));
    }

    public function provide_urls_ok()
    {
        return array(
            array('/api/v1/partners'),
            array('/api/v1/partners/1'),
            array('/api/v1/partners/1/subscriptions'),
            array('/api/v1/partners/1/subscriptions/1'),
        );
    }


    /**
     * @dataProvider provide_urls_no_content
     */
    public function test_url_is_no_content($url)
    {
        $client = static::createClient();
        $client->request('GET', $url);

        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertEquals(Response::HTTP_NO_CONTENT, $client->getResponse()->getStatusCode());
    }

    public function provide_urls_no_content()
    {
        return array(
            array('/api/v1/partners/0'),
            array('/api/v1/partners/0/subscriptions'),
            array('/api/v1/partners/0/subscriptions/1'),
            array('/api/v1/partners/1/subscriptions/0'),
        );
    }

}