<?php

namespace App\Tests\Controller;

use App\Entity\Task;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TaskControllerTest extends WebTestCase
{
    public function testListAction(): void
    {

        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByUsername('admin');

        // simulate $testUser being logged in
        $client->loginUser($testUser);

        $client->request('GET', '/tasks');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testListTaskToDo(): void
    {

        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByUsername('admin');

        // simulate $testUser being logged in
        $client->loginUser($testUser);

        $client->request('GET', '/tasks/todo');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testListTaskDone(): void
    {

        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByUsername('admin');

        // simulate $testUser being logged in
        $client->loginUser($testUser);

        $client->request('GET', '/tasks/done');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testCreateAction()
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByUsername('admin');

        // simulate $testUser being logged in
        $client->loginUser($testUser);

        $crawler = $client->request('GET', '/tasks/create');

        $form = $crawler->selectButton('Ajouter')->form();
        $form['task[title]'] = 'Tâche de test';
        $form['task[content]'] = 'Contenu de tche de test';
        $client->submit($form);
        /* $this->assertResponseIsSuccessful(); */

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $client->followRedirects();
    }

    public function testEditAction()
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByUsername('admin');

        // simulate $testUser being logged in
        $client->loginUser($testUser);

        $entityManager = static::$kernel->getContainer()->get('doctrine')->getManager();
        $task = $entityManager->getRepository(Task::class)->findAll()[0];
        $crawler = $client->request('GET', 'tasks/' . $task->getId() . '/edit');

        $this->assertResponseIsSuccessful();

        $form = $crawler->selectButton('Modifier')->form();
        $form['task[title]'] = 'Tâche modifiée';
        $form['task[content]'] = 'Contenu de la tâche modifié';
        $crawler = $client->submit($form);

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        $crawler = $client->followRedirect();
        $this->assertEquals('task_list', $client->getRequest()->get('_route'));
        $this->assertSame(1, $crawler->filter('div.alert.alert-success')->count());
        $this->assertGreaterThan(0, $crawler->filter('div:contains("Superbe ! La tâche a bien été modifiée.")')->count());
    }

    public function testToggleTaskAction()
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByUsername('admin');

        // simulate $testUser being logged in
        $client->loginUser($testUser);

        $entityManager = static::$kernel->getContainer()->get('doctrine')->getManager();
        $task = $entityManager->getRepository(Task::class)->findAll()[0];
        $crawler = $client->request('GET', 'tasks/' . $task->getId() . '/toggle');

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        $crawler = $client->followRedirect();
        $this->assertEquals('task_list', $client->getRequest()->get('_route'));
        $this->assertSame(1, $crawler->filter('div.alert.alert-success')->count());
        $this->assertGreaterThan(0, $crawler->filter('div:contains("Superbe ! La tâche ' . $task->getTitle() . ' a bien été marquée comme faite.")')->count());
    }
    public function testDeleteTaskActionByAdmin()
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByUsername('admin');

        // simulate $testUser being logged in
        $client->loginUser($testUser);


        $entityManager = static::$kernel->getContainer()->get('doctrine')->getManager();
        $task = $entityManager->getRepository(Task::class)->findAll()[0];
        $crawler = $client->request('GET', 'tasks/' . $task->getId() . '/delete');

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        $crawler = $client->followRedirect();
        $this->assertEquals('task_list', $client->getRequest()->get('_route'));
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testDeleteTaskActionByUser()
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByUsername('user');

        // simulate $testUser being logged in
        $client->loginUser($testUser);


        $entityManager = static::$kernel->getContainer()->get('doctrine')->getManager();
        $task = $entityManager->getRepository(Task::class)->findAll()[0];
        $crawler = $client->request('GET', 'tasks/' . $task->getId() . '/delete');

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        $crawler = $client->followRedirect();
        $this->assertEquals('task_list', $client->getRequest()->get('_route'));
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testDeleteTaskActionForAnonymous()
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByUsername('admin');

        // simulate $testUser being logged in
        $client->loginUser($testUser);


        $entityManager = static::$kernel->getContainer()->get('doctrine')->getManager();
        $task = $entityManager->getRepository(Task::class)->findOneBy(['user' => null]);
        $crawler = $client->request('GET', 'tasks/' . $task->getId() . '/delete');

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        $crawler = $client->followRedirect();
        $this->assertEquals('task_list', $client->getRequest()->get('_route'));
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
