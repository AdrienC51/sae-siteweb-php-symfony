<?php

namespace App\DataFixtures;

use App\Factory\DeliveryFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class DeliveryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        DeliveryFactory::createMany(20);
    }
}
