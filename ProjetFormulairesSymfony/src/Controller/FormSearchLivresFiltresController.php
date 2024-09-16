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
    public function livresSearch(Request $req, LivreRepository $rep): Response
    {

        $form = $this->createForm(SearchFiltreLivresType::class);

        $form->handleRequest($req);

        // gestion du submit du form
        if ($form->isSubmitted()){
        
            // dd($form->getData());

            // $livres = $rep->findAll();

            $livres = $rep->livresEntreDeuxPrix ($form->getData());
            dd($livres);

            $vars = ['livres' => $livres];


            return $this->render ('form_search_livres_filtres/livres_search_afficher.html.twig', $vars);
        }

        $vars = ['form' => $form];

        return $this->render('form_search_livres_filtres/livres_search.html.twig', $vars);
    }
}
