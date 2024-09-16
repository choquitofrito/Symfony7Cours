<?php

namespace App\Controller;

use App\Entity\Livre;
use App\Entity\Aeroport;

use App\Form\AeroportType;
use App\Form\LivreType;
use App\Repository\AeroportRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FormulairesController extends AbstractController
{
    public ManagerRegistry $doctrine;

    // injecter le ManagerRegistry dans le constructeur
    public function __construct(ManagerRegistry $doctrine) {
        $this->doctrine = $doctrine;
    }

    #[Route('/formulaires', name: 'app_formulaires')]
    public function index(): Response
    {
        return $this->render('formulaires/index.html.twig');
    }

    #[Route('/formulaires/aeroport/afficher')]
    public function aeroportAfficher(Request $req)
    {

        // on crée une entité vide
        $aeroport = new Aeroport();

        // on crée le form + associe l'entité au form
        $form = $this->createForm(AeroportType::class, $aeroport);

        // gérer l'objet Request. Cet objet contiendra un GET ou un POST
        $form->handleRequest($req);

        // si c'est POST, on va visualiser le contenu de l'entité
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->doctrine->getManager();
            $em->persist($aeroport);
            $em->flush();

            // 1. possibilité de montrer une autre vue
            // return $this->render('formulaires/une_autre_vue.html.twig');

            // 2. possibilité de renvoyer vers une autre action
            // return $this->redirectToRoute("name_autre_action", { param1: $val1, param2: $val2 })

        }


        $vars = ['formulaireAeroport' => $form];

        return $this->render('formulaires/aeroport_afficher.html.twig', $vars);
    }

    #[Route('/formulaires/livre/form/insert')]
    public function livreFormInsert(Request $req)
    {

        $livre = new Livre();

        $form = $this->createForm(LivreType::class, $livre);

        $form->handleRequest($req);

        if ($form->isSubmitted()) {
            $em = $this->doctrine->getManager();
            $em->persist($livre);
            $em->flush();
            dump($form->getErrors());
            dd("end action");
        }

        $vars = ['form' => $form];
        return $this->render('formulaires/livre_form_insert.html.twig', $vars);
    }

    // action qui affiche tous les aeroports
    #[Route('/formulaires/afficher/aeroports', name:'afficherAeroports')]
    public function afficherAeroports()
    {
        // obtenir tous les aéroports de la BD
        $em = $this->doctrine->getManager();

        $aeroports = $em->getRepository(Aeroport::class)->findAll();

        // envoyer l'array d'aéroports à la vue
        $vars = ['aeroports' => $aeroports];

        return $this->render('formulaires/afficher_aeroports.html.twig', $vars);
    }

    // update de l'aéroport (affichage et traitement du formulaire)
    #[Route('/formulaires/update/aeroport/{id}', name: 'updateAeroport')]
    public function updateAeroport(Request $req, AeroportRepository $rep, EntityManagerInterface $em)
    {
        $id = $req->get('id');
        // chercher l'aéroport
        $aeroport = $rep->find($id);

        $form = $this->createForm(AeroportType::class, $aeroport);

        $form->handleRequest($req);

        if ($form->isSubmitted()) {
            // on a cliqué submit
            $em->flush();
            dd($aeroport);
        }

        $vars = ['form' => $form];

        return $this->render('formulaires/update_aeroport.html.twig', $vars);
    }


    #[Route('/formulaires/delete/aeroport/{id}', name: 'deleteAeroport')]
    public function deleteAeroport(Request $req,
                                AeroportRepository $rep,
                                EntityManagerInterface $em){
        // obtenir l'id de l'aéroport à éffacer
        $id = $req->get ('id');

        // obtenir l'aéroport de la BD
        $aeroport = $rep->find($id);

        // lancer remove
        $em->remove($aeroport);

        // lancer flush
        $em->flush();

        // quoi faire après le delete?
        // dans ce cas, ré-diriger vers l'affichage
        // de tous les aeroports
        return $this->redirectToRoute('afficherAeroports');


    }


}
