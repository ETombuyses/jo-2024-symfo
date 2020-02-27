<?php

namespace App\Repository;

use App\Entity\SportsFamily;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method SportsFamily|null find($id, $lockMode = null, $lockVersion = null)
 * @method SportsFamily|null findOneBy(array $criteria, array $orderBy = null)
 * @method SportsFamily[]    findAll()
 * @method SportsFamily[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SportsFamilyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SportsFamily::class);
    }

    public function getAllFamiliesOfAPractice(int $id_practice) {

        $qb = $this->createQueryBuilder('f');
        $qb->select('f.id')
            ->where(':id_practice MEMBER OF f.idPractice')
            ->setParameter('id_practice', $id_practice);

        $query = $qb->getQuery();
        $result = $query->getResult();

        $families_id = [];

        // exclude athletism, triathlon and pentathlon from the sports families if there is at least 1 sports family
        foreach ($result as $id) {
            if (sizeof($result) < 2) array_push($families_id, (int)$id['id']);
            else if ($id['id'] != 1 && $id['id'] != 5 && $id['id'] != 9) array_push($families_id, (int)$id['id']);
        }

        return $families_id;
    }
}
