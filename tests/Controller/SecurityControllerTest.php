<?php

namespace App\Tests\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerTest extends WebTestCase
{
    private $client;

    public function setUp(): void
    {
        $this->client = static::createClient();
    }

    public function loginUser(): void
    {
        $crawler = $this->client->request('GET', '/login');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $this->assertEquals(1, $crawler->filter('input[name="_username"]')->count());
        $this->assertEquals(1, $crawler->filter('input[name="_password"]')->count());
        $this->assertEquals(1, $crawler->filter('input[name="_csrf_token"]')->count());

        $form = $crawler->selectButton('Se connecter')->form();
        $this->client->submit($form, ['_username' => 'admin', '_password' => 'admin']);
    }

    public function loginInvalidUser(): void
    {
        $crawler = $this->client->request('GET', '/login');
        $form = $crawler->selectButton('Se connecter')->form();
        $this->client->submit($form, ['_username' => 'admin', '_password' => 'wrongpwd']);

        $crawler = $this->client->followRedirect();

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $this->assertSame('L\'utilsateur n\'existe pas.', $crawler->filter('div.alert-danger')->text());
    }

    public function testLogin()
    {
        $this->loginUser();
        $this->client->request('GET', '/');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    public function testLogoutCheck()
    {
        $this->client->followRedirects();

        $this->client->request('GET', '/logout');
        $this->assertResponseIsSuccessful();
    }
}
