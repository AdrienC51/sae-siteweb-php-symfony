<?php

namespace App\Factory;

use App\Entity\Account;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Account>
 */
final class AccountFactory extends PersistentProxyObjectFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    private \Transliterator $transliterator;
    public function __construct()
    {
        $this->transliterator = \Transliterator::create('Any-Latin; Latin-ASCII; Lower()');
    }

    public static function class(): string
    {
        return Account::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array|callable
    {
        $firstName = self::faker()->firstName();
        $lastName = self::faker()->lastName();
        $domainName = self::faker()->domainName();
        $email = $this->normalizeName($firstName.'.'.$lastName).'@'.$domainName;
        $phoneNumber = self::faker()->phoneNumber();

        return [
            'email' => $email,
            'firstname' => $firstName,
            'lastname' => $lastName,
            'password' => 'test',
            'roles' => [],
        ];
    }
    protected function normalizeName(string $name)
    {
        $name = $this->transliterator->transliterate($name);
        $name = preg_replace('/[^a-z0-9.]/', '-', $name);

        return $name;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(Account $account): void {})
        ;
    }
}
