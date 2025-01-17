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
}
