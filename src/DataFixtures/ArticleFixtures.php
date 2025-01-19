<?php

namespace App\DataFixtures;

use App\Factory\ArticleFactory;
use App\Factory\CategoryFactory;
use App\Factory\KeyWordFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ArticleFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        ArticleFactory::createMany(20, function () {
            $categories = [];
            $keywords = [];
            $nbCat = rand(1, 3);
            $nbKeyWord = rand(1, 3);
            for ($i = 0; $i < $nbCat; ++$i) {
                $categories[] = CategoryFactory::random();
            }
            for ($i = 0; $i < $nbKeyWord; ++$i) {
                $keywords[] = KeyWordFactory::random();
            }

            return [
                'categories' => $categories,
                'keyWords' => $keywords,
            ];
        });
        for ($y = 0; $y < 20; ++$y) {
            $categories = [];
            $keywords = [];
            $nbCat = rand(1, 3);
            $nbKeyWord = rand(1, 3);
            for ($i = 0; $i < $nbCat; ++$i) {
                $categories[] = CategoryFactory::random();
            }
            for ($i = 0; $i < $nbKeyWord; ++$i) {
                $keywords[] = KeyWordFactory::random();
            }
            ArticleFactory::createOne([
                'categories' => $categories,
                'keyWords' => $keywords,
            ]);
        }
    }

    public function getDependencies(): array
    {
        return [
            CategoryFixtures::class,
            KeyWordFixtures::class,
        ];
    }
}
