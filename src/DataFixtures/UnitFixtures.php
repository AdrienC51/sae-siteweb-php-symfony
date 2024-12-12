<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Factory\ArticleFactory;
use App\Factory\UnitFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class UnitFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $allArticle=$manager->getRepository(Article::class)->findAll();

        foreach ($allArticle as $article) {
            UnitFactory::createOne(
                ["article" => $article]
            );
        }
        UnitFactory::createMany(20,function (){
            return [
                "article"=> ArticleFactory::random()
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
