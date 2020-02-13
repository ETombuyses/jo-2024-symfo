<?php

namespace App\Repository;

use App\Entity\SportsFacility;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @method SportsFacility|null find($id, $lockMode = null, $lockVersion = null)
 * @method SportsFacility|null findOneBy(array $criteria, array $orderBy = null)
 * @method SportsFacility[]    findAll()
 * @method SportsFacility[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SportsFacilityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SportsFacility::class);
    }

    public function getAmountFacilities($id, $handicap_mobility, $handicap_sensory, $level) {
        $conn = $this->getEntityManager()
            ->getConnection();

        // no filter
        if (!$handicap_mobility && !$handicap_sensory && $level === '') {
            $sql = "SELECT COUNT(f.id) as amount_facilities FROM sports_facility f
                INNER JOIN facility_practice_association a ON f.id = a.id_sports_facility
                INNER JOIN sports_practice p ON p.id = a.id_sports_practice
                WHERE p.id = :id";

            $stmt = $conn->prepare($sql);
            $stmt->bindValue(":id", $id);
            $stmt->execute();
            $result = $stmt->fetch();
            return $result;
        }

        // if: level
        if (!$handicap_mobility && !$handicap_sensory && $level !== '') {
            $sql = "SELECT COUNT(f.id) as amount_facilities FROM sports_facility f
                INNER JOIN facility_practice_association a ON f.id = a.id_sports_facility
                INNER JOIN sports_practice p ON p.id = a.id_sports_practice
                WHERE p.id = :id AND a.practice_level = :level";

            $stmt = $conn->prepare($sql);
            $stmt->bindValue(":id", $id);
            $stmt->bindValue(":level", $level);
            $stmt->execute();
            $result = $stmt->fetch();
            return $result;
        }

        // if: handicap mobility
        if ($handicap_mobility && !$handicap_sensory && $level === '') {
            $sql = "SELECT COUNT(f.id) as amount_facilities FROM sports_facility f
                INNER JOIN facility_practice_association a ON f.id = a.id_sports_facility
                INNER JOIN sports_practice p ON p.id = a.id_sports_practice
                WHERE p.id = :id AND (a.handicap_access_mobility_sport_area = 1 OR a.handicap_access_mobility_locker_room = 1 OR a.handicap_access_mobility_swimming_pool = 1 OR a.handicap_access_mobility_sanitary = 1)";

            $stmt = $conn->prepare($sql);
            $stmt->bindValue(":id", $id);
            $stmt->execute();
            $result = $stmt->fetch();
            return $result;
        }

        // if: handicap sensory
        if (!$handicap_mobility && $handicap_sensory && $level === '') {
            $sql = "SELECT COUNT(f.id) as amount_facilities FROM sports_facility f
                INNER JOIN facility_practice_association a ON f.id = a.id_sports_facility
                INNER JOIN sports_practice p ON p.id = a.id_sports_practice
                WHERE p.id = :id AND (a.handicap_access_sensory_sport_area = 1 OR a.handicap_access_sensory_locker_room = 1 OR a.handicap_access_sensory_sanitary = 1)";

            $stmt = $conn->prepare($sql);
            $stmt->bindValue(":id", $id);
            $stmt->execute();
            $result = $stmt->fetch();
            return $result;
        }

        // if: level + mobility
        if ($handicap_mobility && !$handicap_sensory && $level !== '') {
            $sql = "SELECT COUNT(f.id) as amount_facilities FROM sports_facility f
                INNER JOIN facility_practice_association a ON f.id = a.id_sports_facility
                INNER JOIN sports_practice p ON p.id = a.id_sports_practice
                WHERE p.id = :id AND a.practice_level = :level AND (a.handicap_access_mobility_sport_area = 1 OR a.handicap_access_mobility_locker_room = 1 OR a.handicap_access_mobility_swimming_pool = 1 OR a.handicap_access_mobility_sanitary = 1)";

            $stmt = $conn->prepare($sql);
            $stmt->bindValue(":id", $id);
            $stmt->bindValue(":level", $level);
            $stmt->execute();
            $result = $stmt->fetch();
            return $result;
        }

        // if: level + sensory
        if (!$handicap_mobility && $handicap_sensory && $level !== '') {
            $sql = "SELECT COUNT(f.id) as amount_facilities FROM sports_facility f
                INNER JOIN facility_practice_association a ON f.id = a.id_sports_facility
                INNER JOIN sports_practice p ON p.id = a.id_sports_practice
                WHERE p.id = :id AND a.practice_level = :level AND (a.handicap_access_sensory_sport_area = 1 OR a.handicap_access_sensory_locker_room = 1 OR a.handicap_access_sensory_sanitary = 1)";

            $stmt = $conn->prepare($sql);
            $stmt->bindValue(":id", $id);
            $stmt->bindValue(":level", $level);
            $stmt->execute();
            $result = $stmt->fetch();
            return $result;
        }

        // if: level + sensory + mobility
        if ($handicap_mobility && $handicap_sensory && $level !== '') {
            $sql = "SELECT COUNT(f.id) as amount_facilities FROM sports_facility f
                INNER JOIN facility_practice_association a ON f.id = a.id_sports_facility
                INNER JOIN sports_practice p ON p.id = a.id_sports_practice
                WHERE p.id = :id AND a.practice_level = :level AND ((a.handicap_access_mobility_sport_area = 1 OR a.handicap_access_mobility_locker_room  = 1 OR a.handicap_access_mobility_swimming_pool = 1 OR a.handicap_access_mobility_sanitary = 1) AND (a.handicap_access_sensory_sport_area = 1 OR a.handicap_access_sensory_locker_room  = 1 OR a.handicap_access_sensory_sanitary = 1))";

            $stmt = $conn->prepare($sql);
            $stmt->bindValue(":id", $id);
            $stmt->bindValue(":level", $level);
            $stmt->execute();
            $result = $stmt->fetch();
            return $result;
        }

        // if: sensory + mobility
        if ($handicap_mobility && $handicap_sensory && $level === '') {
            $sql = "SELECT COUNT(f.id) as amount_facilities FROM sports_facility f
                INNER JOIN facility_practice_association a ON f.id = a.id_sports_facility
                INNER JOIN sports_practice p ON p.id = a.id_sports_practice
                WHERE p.id = :id AND ((a.handicap_access_mobility_sport_area = 1 OR a.handicap_access_mobility_locker_room = 1 OR a.handicap_access_mobility_swimming_pool = 1 OR a.handicap_access_mobility_sanitary = 1) AND (a.handicap_access_sensory_sport_area = 1 OR a.handicap_access_sensory_locker_room = 1 OR a.handicap_access_sensory_sanitary = 1))";

            $stmt = $conn->prepare($sql);
            $stmt->bindValue(":id", $id);
            $stmt->execute();
            $result = $stmt->fetch();
            return $result;
        }



    }


    // /**
    //  * @return SportsFacility[] Returns an array of SportsFacility objects
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
    public function findOneBySomeField($value): ?SportsFacility
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
