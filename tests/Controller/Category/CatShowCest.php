<?php


namespace App\Tests\Controller\Category;

use App\Factory\ArticleFactory;
use App\Factory\CategoryFactory;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use App\Tests\Support\ControllerTester;

class CatShowCest
{
    public function showProductByCategory(ControllerTester $I)
    {
        $pharmaCategories =  [
            ['name' => 'Analgesics'],
        ];
        $category = CategoryFactory::createSequence($pharmaCategories)[0];
        ArticleFactory::createOne(['name' => 'doliprane','categories'=>[$category]]);
        ArticleFactory::createOne(['name' => 'Aspirin','categories'=>[]]);
        $I->amOnPage('/category/1');
        $I->seeResponseCodeIsSuccessful();
        $I->seeNumberOfElements('.article_info_shop', 1);
        $I->see('doliprane','.article_info_shop');
        $I->dontSee('aspirin','.article_info_shop');
    }
}
