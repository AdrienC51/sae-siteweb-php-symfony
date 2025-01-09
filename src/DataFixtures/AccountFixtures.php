<?php

namespace App\DataFixtures;

use App\Factory\AccountFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AccountFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        AccountFactory::createOne(['firstname' => 'Tony', 'lastname' => 'Stark', 'email' => 'root@example.com', 'roles' => ['ROLE_ADMIN']]);
        AccountFactory::createOne(['firstname' => 'Peter', 'lastname' => 'Parker', 'email' => 'user@example.com', 'roles' => ['ROLE_USER']]);
        AccountFactory::createMany(150);

        $manager->flush();
    }
}
