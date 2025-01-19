<?php

namespace App\DataFixtures;

use App\Factory\RestockingFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class RestockingFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        RestockingFactory::createMany(30, function () {
            $status = 0 === rand(0, 1) ? 'Pending' : 'Received';

            return [
                'status' => $status,
            ];
        });
    }
}
