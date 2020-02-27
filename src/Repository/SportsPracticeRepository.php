<?php

namespace App\Repository;

use App\Entity\SportsPractice;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\DBAL\Connection;

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
        $result = $stmt->fetchAll();

        return $result;
    }

    public function getOnePracticeData(int $id) {
        $qb = $this->createQueryBuilder('p');
        $qb->select('p.practice, p.imageName')
            ->where('p.id = :id')
            ->setParameter('id', $id);

        $query = $qb->getQuery();
        $result = $query->getResult();
        return $result;
    }



    public function getAllPracticesIdForFamilySports (array $sports_families_id_array) {

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
}
