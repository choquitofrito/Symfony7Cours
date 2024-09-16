<?php

namespace App\Controller;

use App\Form\SearchFiltreLivresType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FormSearchLivresFiltresController extends AbstractController
{
    #[Route('/livres/search', name: 'livres_search')]
    public function livresSearch(Request $req): Response
    {

        $form = $this->createForm(SearchFiltreLivresType::class);

        $form->handleRequest($req);

        // gestion du submit du form
        if ($form->isSubmitted()){
            dd($form->getData());
        }

        $vars = ['form' => $form];

        return $this->render('form_search_livres_filtres/livres_search.html.twig', $vars);
    }
}
