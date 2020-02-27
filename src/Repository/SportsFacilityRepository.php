<?php

namespace App\Repository;

use App\Entity\SportsFacility;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

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

    // complete the WERE clause of an sql request based on the given filters, executes it and return the fetched results
    private function completeSqlRequest(string $sql, int $id, bool $handicap_mobility, bool $handicap_sensory, string $level, int $arrondissement, $fetchAll) {
        $conn = $this->getEntityManager()
            ->getConnection();

        if (!$handicap_mobility && !$handicap_sensory && $level === '' && $arrondissement === -1) {
            // no filter
            $stmt = $conn->prepare($sql);

        } else if (!$handicap_mobility && !$handicap_sensory && $level !== '' && $arrondissement === -1) {
            // if: level
            $sql = $sql . "AND a.practice_level = :level";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue("level", $level);

        } else if ($handicap_mobility && !$handicap_sensory && $level === '' && $arrondissement === -1) {
            // if: handicap mobility
            $sql = $sql . "AND (a.handicap_access_mobility_sport_area = 1 OR a.handicap_access_mobility_locker_room = 1 OR a.handicap_access_mobility_swimming_pool = 1 OR a.handicap_access_mobility_sanitary = 1)";
            $stmt = $conn->prepare($sql);

        } else if (!$handicap_mobility && $handicap_sensory && $level === '' && $arrondissement === -1) {
            // if: handicap sensory
            $sql = $sql . "AND (a.handicap_access_sensory_sport_area = 1 OR a.handicap_access_sensory_locker_room = 1 OR a.handicap_access_sensory_sanitary = 1)";
            $stmt = $conn->prepare($sql);

        } else if ($handicap_mobility && !$handicap_sensory && $level !== '' && $arrondissement === -1) {
            // if: level + mobility
            $sql = $sql . "AND a.practice_level = :level AND (a.handicap_access_mobility_sport_area = 1 OR a.handicap_access_mobility_locker_room = 1 OR a.handicap_access_mobility_swimming_pool = 1 OR a.handicap_access_mobility_sanitary = 1)";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue("level", $level);

        } else if (!$handicap_mobility && $handicap_sensory && $level !== '' && $arrondissement === -1) {
            // if: level + sensory
            $sql = $sql . "AND a.practice_level = :level AND (a.handicap_access_sensory_sport_area = 1 OR a.handicap_access_sensory_locker_room = 1 OR a.handicap_access_sensory_sanitary = 1)";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue("level", $level);

        } else if ($handicap_mobility && $handicap_sensory && $level !== '' && $arrondissement === -1) {
            // if: level + sensory + mobility
            $sql = $sql . "AND a.practice_level = :level AND ((a.handicap_access_mobility_sport_area = 1 OR a.handicap_access_mobility_locker_room  = 1 OR a.handicap_access_mobility_swimming_pool = 1 OR a.handicap_access_mobility_sanitary = 1) AND (a.handicap_access_sensory_sport_area = 1 OR a.handicap_access_sensory_locker_room  = 1 OR a.handicap_access_sensory_sanitary = 1))";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue("level", $level);

        } else if ($handicap_mobility && $handicap_sensory && $level === '' && $arrondissement === -1) {
            // if: sensory + mobility
            $sql = $sql . "AND ((a.handicap_access_mobility_sport_area = 1 OR a.handicap_access_mobility_locker_room = 1 OR a.handicap_access_mobility_swimming_pool = 1 OR a.handicap_access_mobility_sanitary = 1) AND (a.handicap_access_sensory_sport_area = 1 OR a.handicap_access_sensory_locker_room  = 1 OR a.handicap_access_sensory_sanitary = 1))";
            $stmt = $conn->prepare($sql);

        } else if (!$handicap_mobility && !$handicap_sensory && $level === '' && $arrondissement !== -1) {
            // if: arrondissement
            $sql = $sql . "AND f.id_arrondissement = :arrondissement";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue("arrondissement", $arrondissement);

        } else if ($handicap_mobility && !$handicap_sensory && $level === '' && $arrondissement !== -1) {
            // if: arrondissement + mobility
            $sql = $sql . "AND f.id_arrondissement = :arrondissement AND (a.handicap_access_mobility_sport_area = 1 OR a.handicap_access_mobility_locker_room = 1 OR a.handicap_access_mobility_swimming_pool = 1 OR a.handicap_access_mobility_sanitary = 1)";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue("arrondissement", $arrondissement);

        } else if (!$handicap_mobility && $handicap_sensory && $level === '' && $arrondissement !== -1) {
            // if: arrondissement + sensory
            $sql = $sql . "AND f.id_arrondissement = :arrondissement AND (a.handicap_access_sensory_sport_area = 1 OR a.handicap_access_sensory_locker_room = 1 OR a.handicap_access_sensory_sanitary = 1)";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue("arrondissement", $arrondissement);

        } else if (!$handicap_mobility && !$handicap_sensory && $level !== '' && $arrondissement !== -1) {
            // if: arrondissement + level
            $sql = $sql . "AND f.id_arrondissement = :arrondissement AND a.practice_level = :level";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue("arrondissement", $arrondissement);
            $stmt->bindValue("level", $level);

        } else if ($handicap_mobility && !$handicap_sensory && $level !== '' && $arrondissement !== -1) {
            // if: arrondissement + mobility + level
            $sql = $sql . "AND f.id_arrondissement = :arrondissement AND a.practice_level = :level AND (a.handicap_access_mobility_sport_area = 1 OR a.handicap_access_mobility_locker_room = 1 OR a.handicap_access_mobility_swimming_pool = 1 OR a.handicap_access_mobility_sanitary = 1)";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue("arrondissement", $arrondissement);
            $stmt->bindValue("level", $level);

        } else if ($handicap_mobility && $handicap_sensory && $level === '' && $arrondissement !== -1) {
            // if: arrondissement + mobility + sensory
            $sql = $sql . "AND f.id_arrondissement = :arrondissement AND ((a.handicap_access_mobility_sport_area = 1 OR a.handicap_access_mobility_locker_room = 1 OR a.handicap_access_mobility_swimming_pool = 1 OR a.handicap_access_mobility_sanitary = 1) AND (a.handicap_access_sensory_sport_area = 1 OR a.handicap_access_sensory_locker_room  = 1 OR a.handicap_access_sensory_sanitary = 1))";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue("arrondissement", $arrondissement);

        } else if (!$handicap_mobility && $handicap_sensory && $level !== '' && $arrondissement !== -1) {
            // if: arrondissement + sensory + level
            $sql = $sql . "AND f.id_arrondissement = :arrondissement AND a.practice_level = :level AND (a.handicap_access_sensory_sport_area = 1 OR a.handicap_access_sensory_locker_room = 1 OR a.handicap_access_sensory_sanitary = 1)";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue("arrondissement", $arrondissement);
            $stmt->bindValue("level", $level);

        } else if ($handicap_mobility && $handicap_sensory && $level !== '' && $arrondissement !== -1) {
            // if: arrondissement + sensory + mobility + level
            $sql = $sql . "AND f.id_arrondissement = :arrondissement AND a.practice_level = :level AND ((a.handicap_access_mobility_sport_area = 1 OR a.handicap_access_mobility_locker_room = 1 OR a.handicap_access_mobility_swimming_pool = 1 OR a.handicap_access_mobility_sanitary = 1) AND (a.handicap_access_sensory_sport_area = 1 OR a.handicap_access_sensory_locker_room  = 1 OR a.handicap_access_sensory_sanitary = 1))";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue("arrondissement", $arrondissement);
            $stmt->bindValue("level", $level);
        }

        $stmt->bindValue("id", $id);
        $stmt->execute();
        $result = $fetchAll ? $stmt->fetchAll() : $stmt->fetch();
        return $result;
    }


    // return the details of all sports facilities where we can practice a certain sport (id),
    // including the address details and all the handicap accesses for each facility
    public function getAddresses(int $id, bool $handicap_mobility, bool $handicap_sensory, string $level, int $arrondissement) {

        // basic SQL request
        $sql = "SELECT f.facility_name, f.address_number, f.address_street, f.facility_type, ar.postal_code, 
                a.handicap_access_mobility_sport_area, a.handicap_access_sensory_sport_area, a.handicap_access_sensory_locker_room,
                a.handicap_access_mobility_locker_room, a.handicap_access_mobility_swimming_pool, a.handicap_access_sensory_sanitary,
                a.handicap_access_mobility_sanitary 
                FROM sports_facility f
                INNER JOIN arrondissement ar ON f.id_arrondissement = ar.id
                INNER JOIN facility_practice_association a ON a.id_sports_facility = f.id
                INNER JOIN sports_practice p ON p.id = a.id_sports_practice
                WHERE p.id = :id ";

        // complete the WERE clause based on the activated filters (handicaps, level and arrondissement) and execute the request
        $result = $this->completeSqlRequest($sql, $id, $handicap_mobility, $handicap_sensory, $level, $arrondissement, true);
        return $result;
    }


    public function getNumberFacilities(int $id, bool $handicap_mobility, bool $handicap_sensory, string $level, int $arrondissement) {

        // basic SQL request
        $sql = "SELECT COUNT(f.id) as amount_facilities FROM sports_facility f 
                INNER JOIN facility_practice_association a ON f.id = a.id_sports_facility
                INNER JOIN sports_practice p ON p.id = a.id_sports_practice
                WHERE p.id = :id ";

        // complete the WERE clause based on the activated filters (handicaps, level and arrondissement) and execute the request
        $result = $this->completeSqlRequest($sql, $id, $handicap_mobility, $handicap_sensory, $level, $arrondissement, false);
        return $result;
    }



    public function getNumberOfFacilitiesForEachArrondissement(int $id) {
        $conn = $this->getEntityManager()
            ->getConnection();

        $sql = "SELECT f.id_arrondissement, COUNT(f.id) as amount_facilities FROM sports_facility f
            INNER JOIN facility_practice_association a ON f.id = a.id_sports_facility
            INNER JOIN sports_practice p ON p.id = a.id_sports_practice
            WHERE p.id = :id
            GROUP BY f.id_arrondissement";

        $stmt = $conn->prepare($sql);
        $stmt->bindValue("id", $id);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
    }

}



