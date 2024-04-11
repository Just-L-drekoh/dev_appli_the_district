<?php

namespace App\DataFixtures;

use App\Entity\Plat;
use App\Entity\Categorie;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class TheDistrictFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        include 'district.php';
        $categorieRepo = $manager->getRepository(Categorie::class);

        foreach ($categorie as $cat) {
            $categorieDB = new Categorie();
            $categorieDB
                ->setId(intval($cat['id']))
                ->setLibelle($cat['libelle'])
                ->setImage($cat['image'])
                ->setActive($cat['active']);


            $manager->persist($categorieDB);

            $metadata = $manager->getClassMetaData(Categorie::class);
            $metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);
        }

        $manager->flush();

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
    }
}
