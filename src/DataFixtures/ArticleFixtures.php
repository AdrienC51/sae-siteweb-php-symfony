<?php

namespace App\DataFixtures;

use App\Factory\ArticleFactory;
use App\Factory\CategoryFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ArticleFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        ArticleFactory::createMany(20);

    }
    public function getDependencies(): array
    {
        return [
            CategoryFixtures::class,
        ];
    }
}
