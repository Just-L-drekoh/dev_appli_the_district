<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PanierController extends AbstractController
{
    #[Route('/panier', name: 'app_panier')]
    public function panier(EntityManagerInterface $em): Response
    {
        return $this->render('panier/index.html.twig', [
            'controller_name' => 'PanierController',
        ]);
    }
    #[Route('/panier/ajout/id', name: 'app_panier_ajout')]
    public function panier_ajout(EntityManagerInterface $em): Response
    {
        return $this->render('panier/panier_ajout.html.twig', [
            'controller_name' => 'PanierController'
        ]);
    }
}
