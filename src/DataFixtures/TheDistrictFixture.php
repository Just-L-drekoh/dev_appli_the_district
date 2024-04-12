<?php

namespace App\DataFixtures;

use App\Entity\Categorie;

use App\Entity\Plat;
use App\Entity\Detail;
use App\Entity\Commande;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class TheDistrictFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        include 'district.php';
        // $categorieRepo = $manager->getRepository(Categorie::class);

        // foreach ($categorie as $cat) {
        //     $categorieDB = new Categorie();
        //     $categorieDB
        //         ->setId(intval($cat['id']))
        //         ->setLibelle($cat['libelle'])
        //         ->setImage($cat['image'])
        //         ->setActive($cat['active']);


        //     $manager->persist($categorieDB);

        //     $metadata = $manager->getClassMetaData(Categorie::class);
        //     $metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);
        // }

        // $manager->flush();
        // $platRepo = $manager->getRepository(Plat::class);
        // foreach ($plat as $p) {
        //     $platDB = new Plat();
        //     $platDB
        //         ->setLibelle($p['libelle'])
        //         ->setDescription($p['description'])
        //         ->setPrix($p['prix'])
        //         ->setImage($p['image'])
        //         ->setActive($p['active']);
        //     $id = $p['id_categorie'];
        //     $categorie = $categorieRepo->find($id);
        //     $platDB->setCategorie($categorie);
        //     $manager->persist($platDB);
        // }
        // $manager->flush();

        // Insérer les catégories
        foreach ($categorie as $catData) {
            $categorieDB = new Categorie();
            $categorieDB
                ->setLibelle($catData['libelle'])
                ->setImage($catData['image'])
                ->setActive($catData['active']);
            $manager->persist($categorieDB);
        }
        $manager->flush();

        // Récupérer les catégories pour les associer aux plats
        $categories = $manager->getRepository(Categorie::class)->findAll();

        // Insérer les plats
        foreach ($plat as $platData) {
            $platDB = new Plat();
            $platDB
                ->setLibelle($platData['libelle'])
                ->setDescription($platData['description'])
                ->setPrix($platData['prix'])
                ->setImage($platData['image'])
                ->setActive($platData['active']);

            // Associer le plat à sa catégorie en utilisant l'ID de catégorie fourni dans les données
            foreach ($categories as $categorie) {
                if ($categorie->getId() == $platData['id_categorie']) {
                    $platDB->setCategorie($categorie);
                    break;
                }
            }

            $manager->persist($platDB);
        }
        $manager->flush();


        // foreach ($detail as $d) {
        //     $detailDB = new Detail();
        //     $detailDB
        //         ->setQuantite($d['quantite']);
        //     $id = $d['id_plat'];
        //     $plat = $platRepo->find($id);
        //     $detailDB->setPlat($plat);
        //     $manager->persist($detailDB);
        // }
        // $manager->flush();

        // foreach ($commande as $comm) {
        //     $commandeDB = new Commande();
        //     $commandeDB
        //         ->setDateCommande($comm['date_commande']);
        // }
    }
}
