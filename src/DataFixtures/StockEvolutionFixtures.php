<?php

namespace App\DataFixtures;

use App\Factory\StockEvolutionFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class StockEvolutionFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        StockEvolutionFactory::createMany(30, function () {
            $type = 0 === rand(0, 1) ? 'OUT' : 'IN';

            return [
                'type' => $type,
            ];
        });
    }

    public function getDependencies(): array
    {
        return [
            ArticleFixtures::class,
        ];
    }
}
