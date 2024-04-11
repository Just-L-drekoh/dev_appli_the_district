<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Plat;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AccueilController extends AbstractController
{
    #[Route('/accueil', name: 'app_accueil')]
    public function index(EntityManagerInterface $em): Response
    {
        $categories = $em->getRepository(Categorie::class)->findAll();
        $plats = $em->getRepository(Plat::class)->findAll();
        return $this->render('accueil/index.html.twig', [
            'controller_name' => 'AccueilController',
            'categories' => $categories,
            'plats' => $plats,
        ]);
    }
}
