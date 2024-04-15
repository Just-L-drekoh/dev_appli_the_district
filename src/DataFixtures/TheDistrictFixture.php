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

        foreach ($commande as $comm) {
            $commandeDB = new Commande();
            $dateCommande = new \DateTime($comm['date_commande']);
            $commandeDB
                ->setDateCommande($dateCommande)
                ->setTotal($comm['total'])
                ->setEtat($comm['etat']);
            $id = $comm['id_detail'];
            $detail = $detailRepo->find($id);
            $commandeDB->addDetail($detail);
            $manager->persist($commandeDB);
        }
        $manager->flush();

        $commandeRepo = $manager->getRepository(Commande::class);

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
                ->setVille($user['ville'])
                ->setRoles($user['roles']);
            $id = $user['id_commande'];
            $commande = $commandeRepo->find($id);
            $userDB->addCommande($commande);
            $manager->persist($userDB);
        }
        $manager->flush();
    }
}
