<?php
// fixture de liaison
namespace App\DataFixtures;

use Faker\Factory;

use App\Entity\Livre;
use App\Entity\Auteur;

use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class AuteurLivreFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        // obtenir tous les livres
        $repLivre = $manager->getRepository(Livre::class);
        $livres = $repLivre->findAll();

        // obtenir tous les auteurs
        $repAuteur = $manager->getRepository(Auteur::class);
        $auteurs = $repAuteur->findAll();

        
        foreach ($livres as $livre){
            $auteur = $auteurs[mt_rand(0,count($auteurs)-1)];
            $livre->addAuteur($auteur);
        }


        $manager->flush();
    }

    public function getDependencies()
    {
        return [LivreFixtures::class,
                AuteurFixtures::class];
    }
}
