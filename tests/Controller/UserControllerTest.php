<?php


namespace App\Tests\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{


    public function testListAction()
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByUsername('admin');

        // simulate $testUser being logged in
        $client->loginUser($testUser);

        // test e.g. the profile page
        $client->request('GET', '/users');
        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertSelectorTextContains('h1', 'Liste des utilisateurs');
    }
    public function testCreateAction(): void
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByUsername('admin');

        // simulate $testUser being logged in
        $client->loginUser($testUser);

        $crawler = $client->request('GET', '/users/create');

        $form = $crawler->selectButton('Ajouter')->form();
        $createdUserNumber = rand();
        $form['user[username]'] = 'admin_test ' . $createdUserNumber;
        $form['user[password][first]'] = 'password';
        $form['user[password][second]'] = 'password';
        $form['user[roles]'] = 'ROLE_ADMIN';
        $form['user[email]'] = 'admin' . $createdUserNumber . '@admin.com';
        $crawler = $client->submit($form);

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        $crawler = $client->followRedirect();
        $this->assertEquals('user_list', $client->getRequest()->get('_route'));
        $this->assertSame(1, $crawler->filter('div.alert.alert-success')->count());
        $this->assertGreaterThan(0, $crawler->filter('div:contains("utilisateur a bien été ajouté.")')->count());
    }

    public function testEditAction(): void
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByUsername('admin');

        // simulate $testUser being logged in
        $client->loginUser($testUser);

        /* $crawler = $client->request('GET', '/users/4/edit'); */
        $entityManager = static::$kernel->getContainer()->get('doctrine')->getManager();
        $user = $entityManager->getRepository(User::class)->findBy([], ['id' => 'DESC'], 1, 0)[0];
        $crawler = $client->request('GET', 'users/' . $user->getId() . '/edit');

        $this->assertResponseIsSuccessful();

        $form = $crawler->selectButton('Modifier')->form();
        $form['user[roles]'] = 'ROLE_USER';
        $form['user[password][first]'] = 'password2';
        $form['user[password][second]'] = 'password2';
        $crawler = $client->submit($form);

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        $crawler = $client->followRedirect();
        $this->assertEquals('user_list', $client->getRequest()->get('_route'));
        $this->assertSame(1, $crawler->filter('div.alert.alert-success')->count());
        $this->assertGreaterThan(0, $crawler->filter('div:contains("utilisateur a bien été modifié")')->count());
    }
}
