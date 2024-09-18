<?php

namespace App\DataFixtures;


use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{

    private $passwordHasher;

    public function __construct (UserPasswordHasherInterface $passwordHasher){
        $this->passwordHasher = $passwordHasher; 
    }


    public function load(ObjectManager $manager): void
    {

        for ($i = 0; $i < 5; $i++) {
            $user = new User();
            $user->setEmail("user" . $i . "@gmail.com");
            // $user->setRoles(['ROLE_USER']);

            // on crée un password hashé
            $hashedPassword = $this->passwordHasher->hashPassword($user, 'lepassword');

            $user->setNom("nom" . $i);
            $user->setDateNaissance(new \DateTime());
            
            $user->setPassword($hashedPassword);

            $manager->persist($user);
        }

        for ($i = 0; $i < 5; $i++) {
            $user = new User();
            $user->setEmail("admin" . $i . "@gmail.com");
            $user->setRoles(['ROLE_ADMIN']);
            // dd($user->getRoles());
            $hashedPassword = $this->passwordHasher->hashPassword($user, 'lepassword');
            $user->setNom("nom" . ($i + 5));
            $user->setDateNaissance(new \DateTime());

            $user->setPassword($hashedPassword);

            $manager->persist($user);
        }

        $manager->flush();
    }
}
