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
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CatalogueController extends AbstractController
{
    #[Route('/', name: 'app_accueil')]
    public function index(EntityManagerInterface $em): Response
    {
        $best_categories = $em->getRepository(Categorie::class)->bestCategories();
        $plats = $em->getRepository(Plat::class)->findAll();
        $details = $em->getRepository(Detail::class)->findAll();

        return $this->render('catalogue/index.html.twig', [
            'controller_name' => 'CatalogueController',

            'categories' => $best_categories,
            'plats' => $plats,
            'details' => $details,

        ]);
    }

    #[Route('/categories', name: 'app_categories')]
    public function categorie(EntityManagerInterface $em): Response
    {
        $categories = $em->getRepository(Categorie::class)->findAll();

        return $this->render('catalogue/categories.html.twig', [
            'controller_name' => 'CatalogueController',

            'categories' => $categories,
        ]);
    }

    #[Route('/plats', name: 'app_plats')]
    public function plats(EntityManagerInterface $em): Response
    {
        $plats = $em->getRepository(Plat::class)->findAll();

        return $this->render('catalogue/plats.html.twig', [
            'controller_name' => 'CatalogueController',

            'plats' => $plats,
        ]);
    }

    #[Route('/plats/categorie_id', name: 'app_plats_cat')]
    public function plats_cat(EntityManagerInterface $em): Response
    {

        $categories = $em->getRepository(Categorie::class)->findAll();
        $plats = $em->getRepository(Plat::class)->findAll();


        return $this->render('catalogue/plats_cat.html.twig', [
            'controller_name' => 'CatalogueController',

            'categories' => $categories,
            'plats' => $plats,
        ]);
    }
}
