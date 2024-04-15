<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use App\Entity\Plat;
use App\Entity\Detail;
use App\Entity\Commande;
use App\Entity\Utilisateur;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class TheDistrictFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        include 'district.php';


        foreach ($utilisateur as $user) {
            $userDB = new Utilisateur();
            $userDB
                ->setEmail($user['email'])
                ->setPassword($user['password'])
                ->setNom($user['nom'])
                ->setPrenom($user['prenom'])
                ->setTelephone($user['telephone'])
                ->setAdresse($user['adresse'])
                ->setCp($user['cp'])
                ->setVille($user['ville']);

            $manager->persist($userDB);
        }
        $manager->flush();

        foreach ($categorie as $cat) {
            $categorieDB = new Categorie();
            $categorieDB
                ->setLibelle($cat['libelle'])
                ->setImage($cat['image'])
                ->setActive($cat['active']);
            $manager->persist($categorieDB);
        }
        $manager->flush();


        $categorieRepo = $manager->getRepository(Categorie::class);

        // Insérer les plats
        foreach ($plat as $p) {
            $platDB = new Plat();
            $platDB
                ->setLibelle($p['libelle'])
                ->setDescription($p['description'])
                ->setPrix($p['prix'])
                ->setImage($p['image'])
                ->setActive($p['active']);
            $id = $p['id_categorie'];
            $categorie = $categorieRepo->find($id);
            $platDB->setCategorie($categorie);
            $manager->persist($platDB);
        }
        $manager->flush();

        $platRepo = $manager->getRepository(Plat::class);

        foreach ($detail as $d) {
            $detailDB = new Detail();
            $detailDB
                ->setQuantite($d['quantite']);
            $id = $d['id_plat'];
            $plat = $platRepo->find($id);
            $detailDB->setPlat($plat);
            $manager->persist($detailDB);
        }
        $manager->flush();


        $detailRepo = $manager->getRepository(Detail::class);
        $userRepo = $manager->getRepository(Utilisateur::class);
        $user = $userRepo->find(1);
        foreach ($commande as $comm) {
            $commandeDB = new Commande();
            $dateCommande = new \DateTime($comm['date_commande']);
            $commandeDB
                ->setDateCommande($dateCommande)
                ->setTotal($comm['total'])
                ->setEtat($comm['etat'])
                ->setUtilisateur($user);
            $id = $comm['id_detail'];
            $detail = $detailRepo->find($id);
            $commandeDB->addDetail($detail);
            $manager->persist($commandeDB);
        }
        $manager->flush();

        $commandeRepo = $manager->getRepository(Commande::class);
        foreach ($utilisateur as $util) {
            $id_user = $util['id'];
            $id_commande = $util['id_commande'];
            $user = $userRepo->find($id_user);
            $order = $commandeRepo->find($id_commande);
            $user->addCommande($order);
            $order->setUtilisateur($user);
        }

        $manager->flush();
    }
}
