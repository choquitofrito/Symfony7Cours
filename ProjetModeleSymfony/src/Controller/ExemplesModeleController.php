<?php

namespace App\Controller;

use App\Entity\Livre;
use App\Entity\Exemplaire;
use App\Repository\LivreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ExemplesModeleController extends AbstractController
{
    #[Route('/exemples/modele', name: 'app_exemples_modele')]
    public function index(): Response
    {
        return $this->render('exemples_modele/index.html.twig');
    }

    #[Route('/exemple/insert')]
    public function exempleInsert(ManagerRegistry $doctrine)
    {
        $em = $doctrine->getManager();
        $livre = new Livre();
        $livre->setTitre("La vie");
        $livre->setDescription("sur la vie");
        $livre->setDatePublication(new \DateTime());
        $livre->setIsbn("2345234534523452345");
        $livre->setPrix(90);

        // avant l'insertion
        dump($livre);

        $em->persist($livre);
        $em->flush();

        // après l'insertion
        dd($livre);
    }


    // créer un Livre et le mettre à jour
    #[Route('/exemple/update')]
    public function exempleUpdate(ManagerRegistry $doctrine)
    {
        $em = $doctrine->getManager();

        // d'abord on crée un objet et on l'insére
        $livre = new Livre();
        $livre->setTitre("La vie 2");
        $livre->setDescription("sur la vie");
        $livre->setDatePublication(new \DateTime());
        $livre->setIsbn("2345234534523452345");
        $livre->setPrix(90);

        $em->persist($livre);
        $em->flush();

        // on modifie le livre dans le domaine des objets
        $livre->setPrix(20);
        $em->flush();

        dd($livre);
    }

    // SELECT + UPDATE. obtenir un livre de la BD et le mettre à jour
    #[Route('/exemple/select/update')]
    public function exempleSelectUpdate(ManagerRegistry $doctrine)
    {
        // obtenu un objet de la BD
        $em = $doctrine->getManager();
        $rep = $em->getRepository(Livre::class);
        $livre = $rep->find(8);

        // update objet de la BD
        $livre->setTitre("Bonjour tout va bien");
        // le flush suffit!!!
        $em->flush();
        dd($livre);
    }

    // obtenir tous les Livres (version standard)
    #[Route('/exemple/select/all')]
    public function selectAll(ManagerRegistry $doctrine)
    {
        $em = $doctrine->getManager();
        $rep = $em->getRepository(Livre::class);
        $tousLesLivres = $rep->findAll();
        dd($tousLesLivres);
    }

    // obtenir tous les Livres (simplification)
    // (on injecte le repo)
    #[Route('/exemple/select/all/inject/repo')]
    public function selectAllInjectRepo(LivreRepository $rep)
    {
        $tousLesLivres = $rep->findAll();
        dd($tousLesLivres);
    }


    #[Route('/exemple/select/all/inject/entity/manager')]
    public function selectAllInjectEntityManager(EntityManagerInterface $em)
    {
        $rep = $em->getRepository(Livre::class);
        $tousLesLivres = $rep->findAll();
        dd($tousLesLivres);
    }


    // CREER un livre avec deux exemplaires (relation)
    #[Route('exemples/insert/livre/exemplaires')]
    public function exempleInsertLivreExemplaires(ManagerRegistry $doctrine)
    {
        $livre = new Livre();
        $livre->setTitre("Alchimiste");
        $livre->setDescription("Livre sympa");
        $livre->setDatePublication(new \DateTime());
        $livre->setIsbn("84684684");
        $livre->setPrix(190);

        $exemplaire1 = new Exemplaire();
        $exemplaire1->setEtat("bon");
        $exemplaire2 = new Exemplaire();
        $exemplaire2->setEtat("mauvais");
        $livre->addExemplaire($exemplaire1);
        $livre->addExemplaire($exemplaire2);

        $em = $doctrine->getManager();


        $em->persist($livre);
        // si on spécifie cascade persist dans l'entité, on ne doit plus persisté les 
        // objets du côté N
        // $em->persist($exemplaire1);
        // $em->persist($exemplaire2);
        $em->flush();
        dd($livre);
    }


    #[Route('exemples/delete/livre/exemplaires')]
    public function exempleDeleteLivreExemplaires(ManagerRegistry $doctrine) {
        $em = $doctrine->getManager();

        // on obtient un livre d'abord
        $rep = $em->getRepository (Livre::class);
        $livre = $rep->find (12);
        

        // on efface le livre
        $em->remove ($livre);
        $em->flush();
        dd();
    }
}
