<?php

namespace App\Tests;

class HomeCest
{
    public function displayHome(ControllerTester $I): void
    {
        $I->amOnPage('/home');
        $I->seeResponseCodeIsSuccessful();
        $I->seeInTitle('Home');
    }
}