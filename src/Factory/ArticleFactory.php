<?php

namespace App\Factory;

use App\DataFixtures\CategoryFixtures;
use App\Entity\Article;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Article>
 */
final class ArticleFactory extends PersistentProxyObjectFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
    }

    public static function class(): string
    {
        return Article::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array|callable
    {
        $pharmaNames = [
            'Paracetamol ',
            'Ibuprofen ',
            'Vitamin C ',
            'Aspirin ',
            'Amoxicillin ',
            'Cetirizine ',
            'Omeprazole ',
            'Metformin ',
            'Saline Nasal Spray ',
            'Antihistamine Tablets ',
        ];
        $number=rand(100,500);
        $name=self::faker()->randomElement($pharmaNames).$number."mg";
        return [
            'name' => $name,
            'price' => self::faker()->randomFloat(2, 5, 100),
            'description' => self::faker()->sentence(10),
            'picture' => self::faker()->imageUrl(640, 480, 'health', true, 'Pharma Product'),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(Article $article): void {})
        ;
    }
}
