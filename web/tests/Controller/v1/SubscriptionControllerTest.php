<?php

namespace App\Tests\Controller\v1;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response; //https://api.symfony.com/4.1/Symfony/Component/HttpFoundation/Response.html

class SubscriotionControllerTest extends WebTestCase
{
    private $client = null;

    protected function setUp()
	{
        $this->client = $this->createClient(['environment' => 'test']);
        $this->client->disableReboot();
        $this->em = $this->client->getContainer()->get('doctrine.orm.entity_manager');
        $this->em->beginTransaction();
    }

    protected function tearDown()
    {
        $this->em->rollback();
    }

    protected function createAuthenticatedClient()
    {
        $client = $this->client;
        $post = ['_username'=>'admin','_password'=>'pa$$w0rd'];
        $client->request('POST', '/api/v1/tokens', $post);
        $response = $client->getResponse();
        $content = json_decode($response->getContent(), true);

        $client = $this->client;
        $client->setServerParameter('HTTP_Authorization', sprintf('Bearer %s', $content['token']));

        return $client;
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



// AUTHENTICATED



    // GET



    public function test_GET_subscriptions_HTTP_OK()
    {
        $client = $this->createAuthenticatedClient();

        $client->request('GET', '/api/v1/partners/1/subscriptions');
        $response = $client->getResponse();
        $content = json_decode($response->getcontent(), true);

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertSame('application/json', $response->headers->get('content-type'));
        $this->assertEquals('4', count($content));
    }

    public function test_GET_subscriptions_id_HTTP_OK()
    {
        $client = $this->createAuthenticatedClient();

        $client->request('GET', '/api/v1/partners/1/subscriptions/1');
        $response = $client->getResponse();
        $content = json_decode($response->getcontent(), true);

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertSame('application/json', $response->headers->get('content-type'));
        $this->assertEquals('1', $content['id']);
    }

    /**
     * @dataProvider provide_test_GET_subscriptions_HTTP_BAD_REQUEST
     */
    public function test_GET_subscriptions_HTTP_BAD_REQUEST($url = null)
    {
        $client = $this->createAuthenticatedClient();

        $client->request('GET', $url);
        $response = $client->getResponse();
        $content = json_decode($response->getcontent(), true);

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        $this->assertSame('application/json', $response->headers->get('content-type'));
        $this->assertEquals(Response::HTTP_BAD_REQUEST, $content['code']);
    }
    public function provide_test_GET_subscriptions_HTTP_BAD_REQUEST()
    {
        return array(
            array('/api/v1/partners/0/subscriptions'),
            array('/api/v1/partners/0/subscriptions/1'),
            array('/api/v1/partners/1/subscriptions/0'),
        );
    }



    // POST



    public function test_POST_subscriptions_HTTP_CREATED()
    {
        $client = $this->createAuthenticatedClient();

        $post = array('inDate'=>'2019-01-01','outDate'=>'2020-01-01','info'=>'info','price'=>'1.1');
        $client->request('POST', '/api/v1/partners/1/subscriptions', $post);
        $response = $client->getResponse();
        $content = json_decode($response->getcontent(), true);

        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
        $this->assertSame('application/json', $response->headers->get('content-type'));
        $this->assertEquals('5', count($content));
    }

    /**
     * @dataProvider provide_POST_subscriptions_HTTP_BAD_REQUEST
     */
    public function test_POST_subscriptions_HTTP_BAD_REQUEST($data)
    {
        $client = $this->createAuthenticatedClient();

        $client->request('POST', '/api/v1/partners/1/subscriptions', $data);
        $response = $client->getResponse();
        $content = json_decode($response->getcontent(), true);

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        $this->assertSame('application/json', $response->headers->get('content-type'));
        $this->assertEquals(Response::HTTP_BAD_REQUEST, $content['code']);
    }
    public function provide_POST_subscriptions_HTTP_BAD_REQUEST()
    {
        return [
            [[]],
            [[                 'outDate'=>'date','info'=>'info','price'=>'1']],
            [['inDate'=>'date'                  ,'info'=>'info','price'=>'1']],
            [['inDate'=>'date','outDate'=>'date'               ,'price'=>'1']],
            [['inDate'=>'date','outDate'=>'date','info'=>'info'             ]],
            [['inDate'=>'date','outDate'=>'date','info'=>'info','price'=>'1']],
            
            [['inDate'=>'BAD','outDate'=>'2018-08-02','info'=>'info','price'=>'1']],                    // fecha
            [['inDate'=>'02-08-2018','outDate'=>'2018-08-02','info'=>'info','price'=>'1']],             // fecha
            [['inDate'=>'2018-08-02 00:00:00','outDate'=>'2018-08-02','info'=>'info','price'=>'1']],    // fecha
            [['inDate'=>'2018-08-02','outDate'=>'2019-08-02','info'=>'','price'=>'1']],                 // info
            [['inDate'=>'2018-08-02','outDate'=>'2019-08-02','info'=>'info','price'=>'BAD']],           // precio
        ];
    }



    // PATCH



    /**
     * @dataProvider provide_PATCH_subscriptions_HTTP_CREATED
     */
    public function test_PATCH_subscriptions_HTTP_CREATED($post = null)
    {
        $client = $this->createAuthenticatedClient();

        $client->request('PATCH', '/api/v1/partners/1/subscriptions/1', $post);
        $response = $client->getResponse();
        $content = json_decode($response->getcontent(), true);

        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
        $this->assertSame('application/json', $response->headers->get('content-type'));
        $this->assertEquals($post[key($post)], $content[key($post)]);
    }
    public function provide_PATCH_subscriptions_HTTP_CREATED()
    {
        return [
            //[['inDate'=>'2015-12-31']],
            //[['outDate'=>'2015-12-31']],
            [['info'=>'nueva']],
            [['price'=>'1.2']],
        ];
    }

    /**
     * @dataProvider provide_PATCH_subscriptions_HTTP_BAD_REQUEST
     */
    public function test_PATCH_subscriptions_HTTP_BAD_REQUEST($post = null)
    {
        $client = $this->createAuthenticatedClient();

        $client->request('PATCH', '/api/v1/partners/1/subscriptions/1', $post);
        $response = $client->getResponse();
        $content = json_decode($response->getcontent(), true);

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        $this->assertSame('application/json', $response->headers->get('content-type'));
        $this->assertEquals(Response::HTTP_BAD_REQUEST, $content['code']);
    }
    public function provide_PATCH_subscriptions_HTTP_BAD_REQUEST()
    {
        return [
            [[]],
            [['inDate'=>'']],
            [['inDate'=>'BAD']],
            [['outDate'=>'BAD']],
            [['info'=>'']],
            [['price'=>'a']],
            [['price'=>'1,5']],
        ];
    }



    // DELETE



    public function test_DELETE_subscriptions_HTTP_ACCEPTED()
    {
        $client = $this->createAuthenticatedClient();

        $client->request('DELETE', '/api/v1/partners/1/subscriptions/1');
        $response = $client->getResponse();
        $content = json_decode($response->getcontent(), true);

        $this->assertEquals(Response::HTTP_ACCEPTED, $response->getStatusCode());
        $this->assertSame('application/json', $response->headers->get('content-type'));
    }

    public function test_DELETE_subscriptions_HTTP_BAD_REQUEST()
    {
        $client = $this->createAuthenticatedClient();

        $client->request('DELETE', '/api/v1/partners/1/subscriptions/0');
        $response = $client->getResponse();
        $content = json_decode($response->getcontent(), true);

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        $this->assertSame('application/json', $response->headers->get('content-type'));
        $this->assertEquals(Response::HTTP_BAD_REQUEST, $content['code']);
    }
    
}