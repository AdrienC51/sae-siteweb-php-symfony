<?php

namespace App\DataFixtures;

use App\Factory\KeyWordFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class KeyWordFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $diseases = [
        ['word' => 'Diabetes'],         // Chronic metabolic disorder
        ['word' => 'Hypertension'],     // High blood pressure
        ['word' => 'Flu'],              // Common viral infection
        ['word' => 'Asthma'],           // Respiratory condition
        ['word' => 'Arthritis'],        // Joint inflammation
        ['word' => 'COVID-19'],         // Coronavirus disease
        ['word' => 'Tuberculosis'],     // Infectious bacterial disease
        ['word' => 'HIV/AIDS'],         // Immunodeficiency virus
        ['word' => 'Hepatitis'],        // Liver inflammation
        ['word' => 'Pneumonia'],        // Lung infection
        ['word' => 'Malaria'],          // Mosquito-borne disease
        ['word' => 'Dengue'],           // Viral fever from mosquitoes
        ['word' => 'Epilepsy'],         // Neurological disorder
        ['word' => 'Gastroenteritis'],  // Stomach and intestinal infection
        ['word' => 'Migraine'],         // Severe headache disorder
];

        KeyWordFactory::createSequence($diseases);
    }
}
