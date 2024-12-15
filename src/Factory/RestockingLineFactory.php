<?php

namespace App\Factory;

use App\Entity\RestockingLine;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<RestockingLine>
 */
final class RestockingLineFactory extends PersistentProxyObjectFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     *
     */
    public function __construct()
    {
    }

    public static function class(): string
    {
        return RestockingLine::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     *
     */
    protected function defaults(): array|callable
    {
        return [
            'article' => ArticleFactory::random(),
            'quantity' => rand(20,150),
            'restocking' => RestockingFactory::random(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(RestockingLine $restockingLine): void {})
        ;
    }
}
