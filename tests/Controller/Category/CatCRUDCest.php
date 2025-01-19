<?php


namespace App\Tests\Controller\Category;

use App\Factory\AccountFactory;
use App\Factory\ArticleFactory;
use App\Factory\CategoryFactory;
use App\Tests\Support\ControllerTester;
use Codeception\Util\HttpCode;

class CatCRUDCest
{
    public function CRUDActionsRestrictedToAdmin(ControllerTester $I)
    {
        $account = AccountFactory::createOne()->_real();
        $I->amLoggedInAs($account);
        $I->amOnPage('/category/create');
        $I->seeResponseCodeIs(HttpCode::FORBIDDEN);
        $pharmaCategories =  [
            ['name' => 'Analgesics'],
        ];
        $category = CategoryFactory::createSequence($pharmaCategories)[0];
        $I->amOnPage('/category/1/update');
        $I->seeResponseCodeIs(HttpCode::FORBIDDEN);
        $I->amOnPage('/category/1/delete');
        $I->seeResponseCodeIs(HttpCode::FORBIDDEN);
        $admin = AccountFactory::createOne(['roles' => ['ROLE_ADMIN']])->_real();
        $I->amLoggedInAs($admin);
        $I->amOnPage('/category/create');
        $I->seeResponseCodeIsSuccessful();
        $I->amOnPage('/category/1/update');
        $I->seeResponseCodeIsSuccessful();
        $I->amOnPage('/category/1/delete');
        $I->seeResponseCodeIsSuccessful();
    }
    public function CreateACategory(ControllerTester $I)
    {
        $admin = AccountFactory::createOne(['roles' => ['ROLE_ADMIN']])->_real();
        $I->amLoggedInAs($admin);
        ArticleFactory::createOne(['name'=>'art1']);
        ArticleFactory::createOne(['name'=>'art2']);
        $I->amOnPage('/category/create');
        $I->submitForm('form',
            ['category[name]' => 'Analgesics',
                'category[articles]' => [1,2]],
            'submitButton');
        $I->seeCurrentRouteIs('app_category');
        $I->see('Analgesics', '.category');
        $I->amOnPage('/category/1');
        $I->see('art1', '.article_info_shop');
        $I->see('art2', '.article_info_shop');
    }

    public function UpdateACategory(ControllerTester $I)
    {
        $admin = AccountFactory::createOne(['roles' => ['ROLE_ADMIN']])->_real();
        $I->amLoggedInAs($admin);
        $pharmaCategories =  [
            ['name' => 'Analgesics'],
        ];
        ArticleFactory::createOne(['name'=>'art1']);
        $category = CategoryFactory::createSequence($pharmaCategories)[0];
        $I->amOnPage('/category');
        $I->see('Analgesics', '.category');
        $I->dontSee('Test', '.category');
        $I->amOnPage('/category/1');
        $I->dontSee('art1', '.article_info_shop');
        $I->amOnPage('/category/1/update');
        $I->fillField('form input[name="category[name]"]', 'Test');
        $I->checkOption('form input[value="1"]');
        $I->click('Save Changes');
        $I->seeCurrentRouteIs('app_category');
        $I->see('Test', '.category');
        $I->dontSee('Analgesics', '.category');
        $I->amOnPage('/category/1');
        $I->see('art1', '.article_info_shop');
    }

    public function DeleteACategory(ControllerTester $I)
    {
        $admin = AccountFactory::createOne(['roles' => ['ROLE_ADMIN']])->_real();
        $I->amLoggedInAs($admin);
        $article = ArticleFactory::createOne(['name'=>'art1']);
        CategoryFactory::createOne(['name'=>'Analgesics', 'articles'=>[$article]]);

        $I->amOnPage('/category');
        $I->see('Analgesics', '.category');
        $I->amOnPage('/category/1/delete');
        $I->submitForm('form',[
            'form[delete]'=>''
        ],
            'submitButton');
        $I->seeCurrentRouteIs('app_category');
        $I->dontSee('Analgesics', '.category');

    }
}
