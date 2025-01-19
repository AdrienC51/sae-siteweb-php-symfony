<?php

namespace App\Tests\Controller\Order;

use App\Factory\AccountFactory;
use App\Factory\ArticleFactory;
use App\Factory\CartLineFactory;
use App\Factory\ClientFactory;
use App\Factory\DeliveryFactory;
use App\Factory\OrderFactory;
use App\Factory\StockEvolutionFactory;
use App\Tests\Support\ControllerTester;

class OrderCest
{
    private function createAuthenticatedClient(ControllerTester $I)
    {
        $account = AccountFactory::createOne([
            'email' => 'client@example.com',
            'roles' => ['ROLE_USER']
        ])->_real();
        
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
        $delivery = DeliveryFactory::createOne([
            'deliveryDate' => new \DateTime()
        ]);
        
        $article = ArticleFactory::createOne([
            'name' => 'Test Article',
            'price' => 10.00
        ]);
        
        StockEvolutionFactory::createOne([
            'article' => $article,
            'quantity' => 10,
            'type' => 'IN',
            'evolutionDate' => new \DateTime()
        ]);
        
        CartLineFactory::createOne([
            'client' => $client,
            'article' => $article,
            'quantity' => 2
        ]);

        $I->amOnPage('/order/create/' . $client->getId());
        $I->seeCurrentRouteIs('app_order_confirmation');
        $I->see('Commande confirmée');
        $I->see('20 €');
    }

    public function testOrderConfirmation(ControllerTester $I)
    {
        $client = $this->createAuthenticatedClient($I);
        $delivery = DeliveryFactory::createOne([
            'deliveryDate' => new \DateTime()
        ]);
        
        $order = OrderFactory::createOne([
            'client' => $client,
            'delivery' => $delivery,
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
        $delivery = DeliveryFactory::createOne([
            'deliveryDate' => new \DateTime()
        ]);
        
        $order = OrderFactory::createOne([
            'client' => $client,
            'delivery' => $delivery,
            'status' => 'Pending'
        ]);

        $I->amOnPage('/order/payment/' . $order->getId());
        $I->see('Paiement accepté');
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