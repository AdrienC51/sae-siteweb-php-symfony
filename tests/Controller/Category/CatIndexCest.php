<?php


namespace App\Tests\Controller\Category;

use App\Factory\AccountFactory;
use App\Factory\CategoryFactory;
use App\Tests\Support\ControllerTester;

class CatIndexCest
{
    public function showCategoryList(ControllerTester $I)
    {
        $pharmaCategories =  [
            ['name' => 'Analgesics'],
            ['name' => 'Antibiotics'],
            ['name' => 'Antihistamines'],
            ['name' => 'Supplements'],
            ['name' => 'Antacids'],
        ];
        CategoryFactory::createSequence($pharmaCategories);
        $I->amOnPage('/category');
        $I->seeResponseCodeIsSuccessful();
        $I->seeNumberOfElements('.category', 5);
    }

    // tests
    public function clickOnCategory(ControllerTester $I)
    {
        $pharmaCategories =  [
            ['name' => 'Analgesics'],
            ['name' => 'Antibiotics'],
            ['name' => 'Antihistamines'],
            ['name' => 'Supplements'],
            ['name' => 'Antacids'],
        ];
        CategoryFactory::createSequence($pharmaCategories);
        $I->amOnPage('/category');
        $I->seeResponseCodeIsSuccessful();
        $I->click('Analgesics');
        $I->seeCurrentRouteIs('app_category_show', ['id' => 1]);
    }

    public function ClickOnAddCategory(ControllerTester $I)
    {

        $I->amOnPage('/category');
        $I->seeResponseCodeIsSuccessful();
        $I->dontSee('New Category', '.category');
        $admin = AccountFactory::createOne(['roles' => ['ROLE_ADMIN']])->_real();
        $I->amLoggedInAs($admin);
        $I->amOnPage('/category');
        $I->see('New Category', '.category');
        $I->click('New Category');
        $I->seeCurrentRouteIs('app_category_create');
    }
    public function ClickOnEdit(ControllerTester $I)
    {
        $pharmaCategories =  [
            ['name' => 'Analgesics'],
        ];
        CategoryFactory::createSequence($pharmaCategories);
        $I->amOnPage('/category');
        $I->seeResponseCodeIsSuccessful();
        $I->dontSee('edit', 'span');
        $admin = AccountFactory::createOne(['roles' => ['ROLE_ADMIN']])->_real();
        $I->amLoggedInAs($admin);
        $I->amOnPage('/category');
        $I->see('edit', 'span');
        $I->click('edit');
        $I->seeCurrentRouteIs('app_category_update', ['id' => 1]);
    }
    public function ClickOnDelete(ControllerTester $I)
    {
        $pharmaCategories =  [
            ['name' => 'Analgesics'],
        ];
        CategoryFactory::createSequence($pharmaCategories);
        $I->amOnPage('/category');
        $I->seeResponseCodeIsSuccessful();
        $I->dontSee('delete', 'span');
        $admin = AccountFactory::createOne(['roles' => ['ROLE_ADMIN']])->_real();
        $I->amLoggedInAs($admin);
        $I->amOnPage('/category');
        $I->see('delete', 'span');
        $I->click('delete');
        $I->seeCurrentRouteIs('app_category_delete', ['id' => 1]);
    }
}
