<?php

namespace App\DataFixtures;

use App\Entity\Order;
use App\Factory\OrderFactory;
use App\Factory\OrderLineFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class OrderLineFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $allOrders=$manager->getRepository(Order::class)->findAll();

        foreach ($allOrders as $order) {
            OrderLineFactory::createOne(
                [
                    'relatedOrder' => $order
                ]
            );
        }

    }

    public function getDependencies(){
        return [
            OrderFixtures::class
        ];
    }
}
