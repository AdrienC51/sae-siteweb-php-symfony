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

    public function orderArticles(ControllerTester $I): void
    {
        ArticleFactory::createSequence(
            [
                ['name' => 'Tylenol 500mg'],
                ['name' => 'Tylenol 650mg'],
                ['name' => 'Doliprane 500mg'],
                ['name' => 'Doliprane 250mg'],
            ]
        );
        $I->amOnPage('/shop');
        $I->see('Doliprane 500mg');
        $articles = $I->grabMultiple('a.article_name_shop');
        $I->assertCount(4, $articles);
        $I->assertEquals('Doliprane 250mg', $articles[0]);
        $I->assertEquals('Doliprane 500mg', $articles[1]);
        $I->assertEquals('Tylenol 500mg', $articles[2]);
        $I->assertEquals('Tylenol 650mg', $articles[3]);
    }

    public function searchForArticles(ControllerTester $I): void
    {
        ArticleFactory::createSequence(
            [
                ['name' => 'Tylenol 500mg'],
                ['name' => 'Tylenol 650mg'],
                ['name' => 'Doliprane 500mg'],
                ['name' => 'Doliprane 250mg'],
            ]
        );
        $I->amOnPage('/shop');
        $I->fillField("input[name='search']", 'oli');
        $I->click('Search');
        $I->amOnPage('/shop?search=oli');
        $I->see('Doliprane 250mg');
        $I->see('Doliprane 500mg');
    }

    public function filterMinPrice(ControllerTester $I): void
    {
        ArticleFactory::createSequence(
            [
                ['name' => 'Tylenol 500mg', 'price' => 50],
                ['name' => 'Tylenol 650mg', 'price' => 65],
                ['name' => 'Doliprane 500mg', 'price' => 50],
                ['name' => 'Doliprane 250mg', 'price' => 25],
            ]
        );
        $I->amOnPage('/shop');
        $I->fillField("input[name='prix_min']", '30');
        $I->click('Filter');
        $I->amOnPage('/shop?prix_min=30&prix_max=');
        $I->see('Doliprane 500mg');
        $I->dontSee('Doliprane 250mg');
    }

    public function filterMaxPrice(ControllerTester $I): void
    {
        ArticleFactory::createSequence(
            [
                ['name' => 'Tylenol 500mg', 'price' => 50],
                ['name' => 'Tylenol 650mg', 'price' => 65],
                ['name' => 'Doliprane 500mg', 'price' => 50],
                ['name' => 'Doliprane 250mg', 'price' => 25],
            ]
        );
        $I->amOnPage('/shop');
        $I->fillField("input[name='prix_max']", '50');
        $I->click('Filter');
        $I->amOnPage('/shop?prix_min=&prix_max=50');
        $I->see('Tylenol 500mg');
        $I->dontSee('Tylenol 650mg');
    }
}
