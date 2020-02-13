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

    public function getAllFamiliesOfAPractice($id_practice) {
        $conn = $this->getEntityManager()
            ->getConnection();

        $sql = "SELECT f.id FROM sports_family f
                INNER JOIN sports_family_practice_association a ON a.id_sports_family = f.id
                INNER JOIN sports_practice p ON p.id = a.id_practice
                WHERE p.id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(":id", $id_practice);
        $stmt->execute();
        $result = $stmt->fetchAll();

        $only_id_array = [];

        foreach ($result as $id) {
            if (sizeof($result) > 1) {
                if ($id['id'] != 1 && $id['id'] != 5 && $id['id'] != 9) {
                    array_push($only_id_array, (int)$id['id']);
                }
            } else {
                array_push($only_id_array, (int)$id['id']);
            }
        }

        return $only_id_array;
    }



    // /**
    //  * @return SportsFamily[] Returns an array of SportsFamily objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SportsFamily
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
