<?php

namespace App\Tests\Controller;

use App\Entity\Task;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TaskControllerTest extends WebTestCase
{
    private $client;

    protected function setUp(): void
    {
        $this->client = self::createClient();
    }

    public function loginWithAdmin(): void
    {
        $crawler = $this->client->request('GET', '/login');
        $form = $crawler->selectButton('Se connecter')->form();
        $this->client->submit($form, ['_username' => 'admin', '_password' => 'admin']);
    }

    public function loginWithUser(): void
    {
        $crawler = $this->client->request('GET', '/login');
        $form = $crawler->selectButton('Se connecter')->form();
        $this->client->submit($form, ['_username' => 'user', '_password' => 'user']);
    }

    public function testListAction(): void
    {
        $this->loginWithUser();
        $this->client->request('GET', '/tasks');
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
    }

    public function testCreateAction(): void
    {
        /* $this->loginWithAdmin(); */

        $crawler = $this->client->request('GET', '/tasks/create');
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());

        $this->client->request(
            'POST',
            '/tasks/create',
            ['title' => 'test', 'content' => 'test content'],
        );
        var_dump($this->client->getResponse());
        die();
        $this->assertGreaterThan(0, $crawler->filter('div:contains("La tâche a été bien été ajoutée.")')->count());
        /* $this->assertEquals(201, $this->client->getResponse()->getStatusCode()); */


        /* $form = $crawler->selectButton('Ajouter')->form();
        $form['task[title]'] = 'Tâche de test';
        $form['task[content]'] = 'Contenu de la tâche de test';
        $crawler = $this->client->submit($form);
        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->filter('div.alert.alert-success')->count());
        $this->assertGreaterThan(0, $crawler->filter('div:contains("La tâche a été bien été ajoutée.")')->count()); */
    }

    /* public function testEditAction()
    {
        $this->loginWithUser();

        $entityManager = static::$kernel->getContainer()->get('doctrine')->getManager();
        $task = $entityManager->getRepository(Task::class)->findAll()[0];
        $crawler = $this->client->request('GET', 'tasks/' . $task->getId() . '/edit');

        $this->assertResponseIsSuccessful();

        $form = $crawler->selectButton('Modifier')->form();
        $form['task[title]'] = 'Tache modifiée';
        $form['task[content]'] = 'Tache modifiée';
        $crawler = $this->client->submit($form);

        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->filter('div.alert.alert-success')->count());
        $this->assertGreaterThan(0, $crawler->filter('div:contains("Superbe ! La tâche a bien été modifiée.")')->count());
    }

    public function testToggleTaskAction()
    {
        $this->loginWithUser();

        $entityManager = static::$kernel->getContainer()->get('doctrine')->getManager();
        $task = $entityManager->getRepository(Task::class)->findAll()[0];
        $crawler = $this->client->request('GET', 'tasks/' . $task->getId() . '/toggle');

        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->filter('div.alert.alert-success')->count());
        $this->assertGreaterThan(0, $crawler->filter('div:contains("Superbe ! La tâche ' . $task->getTitle() . ' a bien été marquée comme faite.")')->count());
    } */
}
