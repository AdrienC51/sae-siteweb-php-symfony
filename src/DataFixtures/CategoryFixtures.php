<?php

namespace App\DataFixtures;

use App\Factory\CategoryFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $pharmaCategories = [
            ['name' => 'Analgesics'],       // Pain relief medications
            ['name' => 'Antibiotics'],      // Infection treatments
            ['name' => 'Antihistamines'],   // Allergy relief
            ['name' => 'Supplements'],      // Vitamins and dietary aids
            ['name' => 'Antacids'],         // Acid reflux treatments
            ['name' => 'Cough Medicines'],  // Cold and flu relief
            ['name' => 'Antidepressants'],  // Mental health medications
            ['name' => 'Antifungals'],      // Fungal infection treatments
            ['name' => 'Antipyretics'],     // Fever reducers
            ['name' => 'Sedatives'],        // Sleep aids
        ];
        CategoryFactory::createSequence($pharmaCategories);
    }
}
