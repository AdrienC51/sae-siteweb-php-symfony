<?php

namespace App\Tests\Controller\Order;

use App\Factory\AccountFactory;
use App\Factory\ArticleFactory;
use App\Factory\CartLineFactory;
use App\Factory\ClientFactory;
use App\Factory\OrderFactory;
use App\Tests\Support\ControllerTester;

class OrderCest
{
    private function createAuthenticatedClient(ControllerTester $I)
    {
        $account = AccountFactory::createOne([
            'email' => 'client@example.com',
            'roles' => ['ROLE_USER']
        ])->object();
        $I->amLoggedInAs($account);
        
        return ClientFactory::createOne([
            'account' => $account,
            'address' => '123 rue Test',
            'postCode' => '75000',
            'city' => 'Paris'
        ]);
    }

    public function testCreateOrder(ControllerTester $I)
    {
        $client = $this->createAuthenticatedClient($I);
        $article = ArticleFactory::createOne([
            'name' => 'Test Article',
            'price' => 10.00
        ]);
        
        CartLineFactory::createOne([
            'client' => $client,
            'article' => $article,
            'quantity' => 2
        ]);

        $I->amOnPage('/order/create/' . $client->getId());
        $I->seeCurrentRouteIs('app_order_confirmation');
        $I->see('Commande confirmée');
    }

    public function testOrderConfirmation(ControllerTester $I)
    {
        $client = $this->createAuthenticatedClient($I);
        $order = OrderFactory::createOne([
            'client' => $client,
            'status' => 'Pending',
            'destAddress' => '123 rue Test',
            'destPostCode' => '75000',
            'destCity' => 'Paris',
            'orderDate' => new \DateTime()
        ]);

        $I->amOnPage('/order/confirmation/' . $order->getId());
        $I->seeResponseCodeIsSuccessful();
        $I->see('Commande confirmée');
    }

    public function testPayment(ControllerTester $I)
    {
        $client = $this->createAuthenticatedClient($I);
        $order = OrderFactory::createOne([
            'client' => $client,
            'status' => 'Pending'
        ]);
        
        $article = ArticleFactory::createOne();
        CartLineFactory::createOne([
            'client' => $client,
            'article' => $article
        ]);

        $I->amOnPage('/order/payment/' . $order->getId());
        $I->seeCurrentRouteIs('app_payment_success');
    }

    public function testInsufficientStock(ControllerTester $I)
    {
        $client = $this->createAuthenticatedClient($I);
        $article = ArticleFactory::createOne();
        
        CartLineFactory::createOne([
            'client' => $client,
            'article' => $article,
            'quantity' => 999
        ]);

        $I->amOnPage('/order/create/' . $client->getId());
        $I->seeCurrentRouteIs('app_cart');
        $I->see('Stock insuffisant');
    }
}