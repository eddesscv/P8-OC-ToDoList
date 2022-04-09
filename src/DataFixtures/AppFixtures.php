<?php

namespace App\DataFixtures;

use App\Entity\Task;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{

    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager): void
    {
        // create 2 Users : Admin User et Simple User !
        // Admin User
        $user = new User();
        $user->setUsername('admin')
            ->setEmail('admin@example.org')
            ->setPassword($this->encoder->encodePassword($user, 'admin'))
            ->setRoles(['ROLE_ADMIN']);
        $manager->persist($user);

        // Simple User
        $user = new User();
        $user->setUsername('user')
            ->setEmail('user@example.org')
            ->setPassword($this->encoder->encodePassword($user, 'user'))
            ->setRoles(['ROLE_USER']);
        $manager->persist($user);


        // create 9 tâches! Bam!
        for ($i = 1; $i < 10; $i++) {
            $task = new Task();
            $task->setTitle('Tâche ' . $i);
            $task->setContent('Contenu ' . $i . '- Cette tâche est une tâche importante, car... dignissimos magni aut aliquid sint ea repellendus illum ut atque voluptatem in voluptatem numquam.');
            $task->setIsDone(mt_rand(0, 1));
            $manager->persist($task);
        }

        $manager->flush();
    }
}
