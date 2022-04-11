<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

abstract class AbstractControllerTest extends WebTestCase
{

    protected $client;

    protected function setUp(): void
    {
        $this->client = static::createClient();
    }

    public function loginWithAdmin(): void
    {
        $crawler = $this->client->request('GET', '/login');

        $buttonCrawlerMode = $crawler->filter('form');
        $form = $buttonCrawlerMode->form([
            'username' => 'admin',
            'password' => 'admin'
        ]);

        $this->client->submit($form);
    }

    public function loginWithUser(): void
    {
        $crawler = $this->client->request('GET', '/login');

        $buttonCrawlerMode = $crawler->filter('form');
        $form = $buttonCrawlerMode->form([
            'username' => 'user',
            'password' => 'user'
        ]);

        $this->client->submit($form);
    }
}
