<?php

namespace App\Tests\Controller\Cart;

use App\Factory\AccountFactory;
use App\Factory\ClientFactory;
use App\Tests\Support\ControllerTester;

class ListCest
{
    public function testListClients(ControllerTester $I)
    {
        $account = AccountFactory::createOne([
            'firstname' => 'John',
            'lastname' => 'Doe',
            'email' => 'john@example.com'
        ]);
        
        ClientFactory::createOne(['account' => $account]);

        $I->amOnPage('/cart');
        $I->seeResponseCodeIsSuccessful();
        $I->see('John Doe');
        $I->seeNumberOfElements('.list-group-item', 1);
    }
}