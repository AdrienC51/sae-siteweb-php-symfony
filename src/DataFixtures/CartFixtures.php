<?php

namespace App\DataFixtures;

use App\Factory\CartFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use function Zenstruck\Foundry\restorePhpUnitErrorHandler;

class CartFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        CartFactory::createMany(10);
    }
    public function getDependencies(){
        return[
            ClientFixtures::class,
        ];
    }
}
