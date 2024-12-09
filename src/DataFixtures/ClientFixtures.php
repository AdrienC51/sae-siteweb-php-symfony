<?php

namespace App\DataFixtures;

use App\Factory\AccountFactory;
use App\Factory\ClientFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use function Zenstruck\Foundry\faker;
use function Zenstruck\Foundry\Persistence\repository;

class ClientFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        ClientFactory::createMany(50);
    }
     public function getDependencies()
    {
        return [
            AccountFixtures::class,
        ];
    }

}
