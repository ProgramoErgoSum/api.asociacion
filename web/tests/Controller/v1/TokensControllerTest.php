<?php

namespace App\Tests\Controller\v1;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class TokensControllerTest extends WebTestCase
{
    private $client = null;

    protected function setUp()
	{
        $this->client = static::createClient();
    }

    /**
     * @dataProvider provide_POST_tokens_HTTP_OK
     */
    public function test_POST_tokens_HTTP_OK($post = null)
    {
        $client = $this->client;
        $client->request('POST', '/api/v1/tokens', $post);
        $response = $client->getResponse();
        $content = json_decode($response->getContent(), true);

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertSame('application/json', $response->headers->get('content-type'));
        $this->assertArrayHasKey('token', $content);
    }
    public function provide_POST_tokens_HTTP_OK()
    {
        return [
            [['_username'=>'admin','_password'=>'pa$$w0rd']],
        ];
    }

    /**
     * @dataProvider provide_POST_tokens_HTTP_BAD_REQUEST
     */
    public function test_POST_tokens_HTTP_BAD_REQUEST($post = null)
    {
        $client = $this->client;
        $client->request('POST', '/api/v1/tokens', $post);
        $response = $client->getResponse();
        $content = json_decode($response->getContent(), true);

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        $this->assertSame('application/json', $response->headers->get('content-type'));
        $this->assertEquals(Response::HTTP_BAD_REQUEST, $content['code']);
    }
    public function provide_POST_tokens_HTTP_BAD_REQUEST()
    {
        return [
            [[]],
            [['_username'=>'BAD_USERNAME']],
            [['_password'=>'BAD_PASSWORD']],
            [['_username'=>'BAD_USERNAME','_password'=>'BAD_PASSWORD']],
        ];
    }

}