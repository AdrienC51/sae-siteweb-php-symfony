<?php

namespace App\DataFixtures;

use App\Entity\StockEvolution;
use App\Factory\CategoryFactory;
use App\Factory\StockEvolutionFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class StockEvolutionFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        StockEvolutionFactory::createMany(30,function (){
             $type = rand(0, 1) === 0 ? "OUT" : "IN";
            return [
                'type' => $type,
            ];
        });
    }
    public function getDependencies(): array
    {
        return[
            ArticleFixtures::class,
        ];
    }
}
