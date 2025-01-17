<?php

namespace App\Tests\Controller\Shop;

use App\Factory\ArticleFactory;
use App\Tests\Support\ControllerTester;

class IndexCest
{
    public function listOfArticles(ControllerTester $I): void
    {
        ArticleFactory::createMany(5);
        $I->amOnPage('/shop');
        $I->seeResponseCodeIsSuccessful();
        $I->seeInTitle('Shop');
        $I->seeNumberOfElements('div.article_shop', 5);
    }

    public function clickOnArticle(ControllerTester $I): void
    {
        ArticleFactory::createOne(
            [
                'name' => 'Doliprane 500mg',
            ],
        );
        ArticleFactory::createMany(5);
        $I->amOnPage('/shop');
        $I->click('Doliprane 500mg');
        $I->seeResponseCodeIsSuccessful();
        $I->amOnPage('/article/1');
    }
}
