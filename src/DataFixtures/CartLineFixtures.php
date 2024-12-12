<?php

namespace App\DataFixtures;

use App\Factory\CartLineFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CartLineFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        CartLineFactory::createMany(50);
    }
    public function getDependencies(){
        return [
            ArticleFixtures::class,
            CartFixtures::class,
        ];
    }
}
