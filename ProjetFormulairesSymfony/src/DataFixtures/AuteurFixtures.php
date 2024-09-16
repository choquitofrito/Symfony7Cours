<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Auteur;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AuteurFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create("fr_BE");

        for ($i = 0; $i < 100; $i++) {
            $auteur = new Auteur(
                [
                    'nom' => $faker->name(),
                    'nationalite' => $faker->countryCode(),
                ]
            );
            $manager->persist($auteur);
        }

        $manager->flush();
    }
}
