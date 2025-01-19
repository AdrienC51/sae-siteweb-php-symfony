<?php

namespace App\Tests\Controller\Purchase;

use App\Tests\Support\ControllerTester;

class PurchaseCest
{
    public function testShowPurchasePage(ControllerTester $I)
    {
        $I->amOnPage('/purchase');
        $I->seeResponseCodeIsSuccessful();
        $I->see('Secure Payment', 'h2');
    }

    public function testConfirmPurchaseValidData(ControllerTester $I)
    {
        $I->amOnPage('/purchase');

        $I->submitForm('form', [
            'cardNumber' => '4111 1111 1111 1111',
            'expiryDate' => '12/25',
            'cvv' => '123',
            'cardHolder' => 'John Doe',
        ]);

        $I->amOnPage('/purchase/success');
        $I->seeResponseCodeIsSuccessful();
        $I->see('Purchase Complete', 'h2');
    }
}
