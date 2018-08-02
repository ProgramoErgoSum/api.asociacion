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
     * @dataProvider provide_urls_ok
     */
    public function test_url_is_ok($url)
    {
        $client = $this->client;
        $client->request('GET', $url);
        $response = $client->getResponse();

        $this->assertTrue($response->isSuccessful());
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertSame('application/json', $response->headers->get('content-type'));
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
        $client = $this->client;
        $client->request('GET', $url);
        $response = $client->getResponse();

        $this->assertTrue($response->isSuccessful());
        $this->assertEquals(Response::HTTP_NO_CONTENT, $response->getStatusCode());
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