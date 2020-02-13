<?php

namespace App\Repository;

use App\Entity\SportsPractice;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\DBAL\Connection;
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

    public function getAllOlympicsPractices() {
        $conn = $this->getEntityManager()
            ->getConnection();

        $sql = "SELECT DISTINCT p.id, p.practice, p.image_name
                FROM sports_practice p
                INNER JOIN olympic_event o ON p.id = o.id_sports_practice";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();

        return $result;
    }

    public function getAllOlympicsPracticesByDate($date) {
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

            return $result;
    }

    public function getOnePracticeData($id) {
        $conn = $this->getEntityManager()
            ->getConnection();

        $sql = "SELECT practice, image_name
                FROM sports_practice
                WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue("id", $id);

        $stmt->execute();
        $result = $stmt->fetchAll();

        return $result;
    }

    public function getAllPracticesIdForFamilySports ($sports_families_id_array) {

        $conn = $this->getEntityManager()
            ->getConnection();


        $stmt = $conn->executeQuery("SELECT DISTINCT p.id FROM sports_practice p
                INNER JOIN sports_family_practice_association a ON p.id = a.id_practice
                INNER JOIN sports_family f ON a.id_sports_family = f.id
                WHERE f.id IN (?)",
                array($sports_families_id_array),
                array(Connection::PARAM_INT_ARRAY));
        $result = $stmt->fetchAll();

        $practices_ids = [];

        foreach ($result as $id) {
            array_push($practices_ids, (int)$id['id']);
        }

        return $practices_ids;

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
