<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PartnerControllerTest extends WebTestCase
{
    public function testGetPartners()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/api/v1/partners');
        
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}