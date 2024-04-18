<?php

namespace App\Repository;

use App\Entity\Plat;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Plat>
 *
 * @method Plat|null find($id, $lockMode = null, $lockVersion = null)
 * @method Plat|null findOneBy(array $criteria, array $orderBy = null)
 * @method Plat[]    findAll()
 * @method Plat[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlatRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Plat::class);
    }

    public function bestPlats(): array
    {

        $em = $this->getEntityManager();
        $query = $em->createQuery(
            'SELECT p
            FROM App\Entity\Categorie c
            JOIN App\Entity\Plat p WITH p.categorie = c
            JOIN App\Entity\Detail d WITH d.plat = p
            GROUP BY c.libelle
            ORDER BY SUM(d.quantite) DESC'
        );
        $query->setMaxResults(5);
        return $query->getResult();
    }
}
