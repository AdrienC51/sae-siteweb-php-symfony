<?php

namespace App\DataFixtures;

use App\Factory\RestockingLineFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class RestockingLineFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        RestockingLineFactory::createMany(40);
    }

    public function getDependencies(): array
    {
        return [
            ArticleFixtures::class,
            RestockingFixtures::class,
        ];
    }
}
