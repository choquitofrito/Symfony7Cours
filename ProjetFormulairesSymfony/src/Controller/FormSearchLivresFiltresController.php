<?php

namespace App\Controller;

use App\Form\SearchFiltreLivresType;
use App\Repository\LivreRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FormSearchLivresFiltresController extends AbstractController
{
    #[Route('/livres/search', name: 'livres_search')]
    public function livresSearch(): Response
    {

        $form = $this->createForm(
            SearchFiltreLivresType::class
        );

        $vars = ['form' => $form];

        return $this->render('form_search_livres_filtres/livres_search.html.twig', $vars);
    }


    #[Route('/livres/search/afficher/resultat', name: 'livres_search_afficher_resultat')]
    public function livresSearchAfficherResultat(Request $req, LivreRepository $rep)
    {

        $form = $this->createForm(SearchFiltreLivresType::class);

        $form->handleRequest($req);

        $livres = [];
        // gestion du submit du form
        if ($form->isSubmitted()) {


            $livres = $rep->livresEntreDeuxPrix($form->getData());

            $vars = ['livres' => $livres];

            // ne rendez pas une vue ici, la bonne pratique est de ré-diriger vers une action
            // return $this->render ('form_search_livres_filtres/livres_search_afficher.html.twig', $vars);
            return $this->render('form_search_livres_filtres/livres_search_afficher_resultat.html.twig', $vars);
        }
    }
}
