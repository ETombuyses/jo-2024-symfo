<?php

namespace App\Repository;

use App\Entity\SportsPractice;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @method SportsPractice|null find($id, $lockMode = null, $lockVersion = null)
 * @method SportsPractice|null findOneBy(array $criteria, array $orderBy = null)
 * @method SportsPractice[]    findAll()
 * @method SportsPractice[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SportsPracticeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SportsPractice::class);
    }

    public function getLevelFilters() {
        $conn = $this->getEntityManager()
            ->getConnection();

        $sql = "select DISTINCT practice_level FROM facility_practice_association WHERE practice_level is NOT NULL";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $levels = [];

        foreach ($stmt as $result) {
            array_push($levels, $result['practice_level']);
        }

        $response = new JsonResponse($levels);
        return $response;
    }

    public function getArrondissementCurrentEvents($id_arrondissement, $date) {

        $conn = $this->getEntityManager()
            ->getConnection();

        $sql = "SELECT p.practice, p.image_name FROM sports_practice p
                INNER JOIN olympic_event o ON p.id = o.id_sports_practice
                WHERE o.date = :date AND o.id_arrondissement = :id_arrondissement";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue("date", $date);
        $stmt->bindValue("id_arrondissement", $id_arrondissement);
        $stmt->execute();
        $result = $stmt->fetchAll();

        $response = new JsonResponse($result);
        return $response;
    }

    public function getAllOlympicsPractices($date) {
        $conn = $this->getEntityManager()
            ->getConnection();

        $sql = "SELECT DISTINCT p.id, p.practice, p.image_name
                FROM sports_practice p
                INNER JOIN olympic_event o ON p.id = o.id_sports_practice
                WHERE o.date = :date";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue("date", $date);
        $stmt->execute();
        $result = $stmt->fetchAll();

        $response = new JsonResponse($result);
        return $response;
    }

    // /**
    //  * @return SportsPractice[] Returns an array of SportsPractice objects
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
    public function findOneBySomeField($value): ?SportsPractice
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
