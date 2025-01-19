<?php

namespace App\Tests\Controller\Cart;

use App\Factory\ArticleFactory;
use App\Factory\CartLineFactory;
use App\Factory\ClientFactory;
use App\Tests\Support\ControllerTester;

class CartCest
{
    public function testShowCart(ControllerTester $I)
    {
        $client = ClientFactory::createOne();
        $article = ArticleFactory::createOne([
            'name' => 'Test Article',
            'price' => 10.00
        ]);
        
        CartLineFactory::createOne([
            'client' => $client,
            'article' => $article,
            'quantity' => 2
        ]);

        // Tests
        $I->amOnPage('/cart/' . $client->getId());
        $I->seeResponseCodeIsSuccessful();
        $I->see('Test Article');
        $I->see('10 €'); // Prix unitaire
        $I->see('20 €'); // Total ligne
    }

    public function testUpdateQuantity(ControllerTester $I)
    {
        $client = ClientFactory::createOne();
        $article = ArticleFactory::createOne([
            'name' => 'Test Article',
            'price' => 10.00
        ]);
        
        $cartLine = CartLineFactory::createOne([
            'client' => $client,
            'article' => $article,
            'quantity' => 1
        ]);

        $I->amOnPage('/cart/' . $client->getId());
        $I->submitForm('form[action*="update"]', [
            'quantity' => 3
        ]);
        $I->seeCurrentRouteIs('app_cart', ['clientId' => $client->getId()]);
        $I->see('30 €'); // Total ligne après mise à jour
    }

    public function testRemoveFromCart(ControllerTester $I)
    {
        $client = ClientFactory::createOne();
        $article = ArticleFactory::createOne([
            'name' => 'Test Article',
            'price' => 10.00
        ]);
        
        $cartLine = CartLineFactory::createOne([
            'client' => $client,
            'article' => $article
        ]);

        $I->amOnPage('/cart/' . $client->getId());
        $I->click('.btn-danger');
        $I->seeCurrentRouteIs('app_cart', ['clientId' => $client->getId()]);
        $I->dontSee('Test Article');
    }
}