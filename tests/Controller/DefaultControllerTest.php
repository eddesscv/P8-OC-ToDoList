<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndexActionWithoutLogin()
    {
        // If the user isn't logged, should redirect to the login page
        $client = static::createClient();
        $client->request('GET', '/');
        $this->assertSame(302, $client->getResponse()->getStatusCode());

        $crawler = $client->followRedirect();
        // Test if login field exists
        $this->assertSame(1, $crawler->filter('input[name="_username"]')->count());
        $this->assertSame(1, $crawler->filter('input[name="_password"]')->count());
        $this->assertSame(1, $crawler->filter('input[name="_csrf_token"]')->count());
    }
}
