<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\Utilisateur;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\UtilisateurRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProfileController extends AbstractController
{


    private $userRepo;
    public function __construct(UtilisateurRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }
    #[Route('/profile', name: 'app_profile')]
    public function index(EntityManagerInterface $em): Response
    {

        $identifiant = $this->getUser()->getUserIdentifier();
        if ($identifiant) {
            $info = $this->userRepo->findOneBy(["email" => $identifiant]);
        }
        $commande = $em->getRepository(Commande::class)->findAll();
        return $this->render('profile/index.html.twig', [
            'controller_name' => 'ProfileController',
            'informations' => $info,
            'commandes' => $commande,

        ]);
    }
}
