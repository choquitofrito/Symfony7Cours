<?php

namespace App\Controller;

use App\Form\SearchFiltreLivresType;
use App\Repository\LivreRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\SerializerInterface;

class FormSearchLivresFiltresController extends AbstractController
{
    #[Route('/livres/search', name: 'livres_search')]
    public function livresSearch(Request $req, 
                                LivreRepository $rep,
                                SerializerInterface $serializer): Response
    {

        $form = $this->createForm(SearchFiltreLivresType::class);

        $form->handleRequest($req);

        // gestion du submit du form
        if ($form->isSubmitted()){
            $livres = $rep->livresEntreDeuxPrix ($form->getData());
            // dump ($form->getData()); // les filtres
            // dd ($livres); // le résultat de la requête
            $livresJson = $serializer->serialize($livres,'json');
            // dd ($livresJson); // le résultat de la requête encodé en JSON
            return new Response($livresJson);
        }

        $vars = ['form' => $form];

        return $this->render('form_search_livres_filtres/livres_search.html.twig', $vars);
    }


    #[Route('/livres/search/afficher/resultat', name: 'livres_search_afficher_resultat')]
    public function livresSearchAfficherResultat (){
            return $this->render ('form_search_livres_filtres/livres_search_afficher_resultat.html.twig');
    }

    

}
