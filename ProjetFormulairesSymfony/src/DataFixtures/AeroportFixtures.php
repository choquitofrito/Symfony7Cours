<?php

namespace App\DataFixtures;

use App\Entity\Aeroport;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AeroportFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 100; $i++){
            $aeroport = new Aeroport(
                ['nom' => 'Brussels Zaventem ',
                'code'=> 'BRU',
                'description' => 'on vole',
                'dateMiseEnService' => new DateTime(),
                // en utilisant l'hydrate, on envoie ce qu'on veut
                ]
            );
            $manager->persist($aeroport);
        }
        // un seul flush!!!!
        $manager->flush();
    }
}
