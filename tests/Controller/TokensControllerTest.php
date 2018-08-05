<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class TokensControllerTest extends WebTestCase
{
    private $client = null;

    protected function setUp()
	{
        $this->client = static::createClient();
    }


    public function test_POST_tokens_HTTP_OK()
    {
        $client = $this->client;
        $post = array('_username'=>'admin','_password'=>'pa$$w0rd');
        $client->request('POST', '/tokens', $post);
        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertSame('application/json', $response->headers->get('content-type'));

        $content = json_decode($response->getContent(), true);

        $this->assertArrayHasKey('token', $content);
    }

    /**
     * @dataProvider provide_POST_tokens_HTTP_BAD_REQUEST
     */
    public function test_POST_tokens_HTTP_BAD_REQUEST($post = null)
    {
        $client = $this->client;
        $client->request('POST', '/tokens', $post);
        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        $this->assertSame('application/json', $response->headers->get('content-type'));

        $content = json_decode($response->getContent(), true);

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $content['code']);
    }
    public function provide_POST_tokens_HTTP_BAD_REQUEST()
    {
        return array(
            array([]),
            array(['_username'=>'BAD_USERNAME']),
            array(['_password'=>'BAD_PASSWORD']),
            array(['_username'=>'BAD_USERNAME', '_password'=>'BAD_PASSWORD']),
        );
    }

}