<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Plat;
use App\Entity\Commande;
use App\Entity\Detail;
use App\Entity\Utilisateur;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CatalogueController extends AbstractController
{

    public function index(EntityManagerInterface $em): Response
    {
        $best_categories = $em->getRepository(Categorie::class)->bestCategories();
        $best_plats = $em->getRepository(Plat::class)->bestPlats();


        return $this->render('catalogue/index.html.twig', [
            'controller_name' => 'CatalogueController',

            'categories' => $best_categories,
            'plats' => $best_plats,


        ]);
    }


    public function categorie(EntityManagerInterface $em): Response
    {
        $categories = $em->getRepository(Categorie::class)->findAll();

        return $this->render('catalogue/categories.html.twig', [
            'controller_name' => 'CatalogueController',

            'categories' => $categories,
        ]);
    }

    public function plats(EntityManagerInterface $em): Response
    {
        $plats = $em->getRepository(Plat::class)->findAll();

        return $this->render('catalogue/plats.html.twig', [
            'controller_name' => 'CatalogueController',

            'plats' => $plats,
        ]);
    }


    public function plats_cat(EntityManagerInterface $em, Request $request, string $libelle): Response
    {
        $libelle = $request->attributes->get('libelle');


        $categorie = $em->getRepository(Categorie::class)->findOneBy(['libelle' => $libelle]);


        $plats = $categorie->getPlats();

        return $this->render('catalogue/plats_cat.html.twig', [
            'controller_name' => 'CatalogueController',
            'categorie' => $categorie,
            'plats' => $plats,

        ]);
    }
}
