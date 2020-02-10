<?php

namespace App\Repository;

use App\Entity\SportsFacility;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use http\QueryString;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;


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

    public function getAll() {
        $response = [];
        $results = $this->findAll();

        if ($results) {
            foreach ($results as $result) {
                array_push($response, [
                    'id' => $result->getId(),
                    'practiceLevel' => $result->getPracticeLevel(),
                    'handicapAccessMobilitySportArea' => $result->getHandicapAccessMobilitySportArea(),
                    'handicapAccessSensorySportArea' => $result->getHandicapAccessSensorySportArea(),
                    'handicapAccessSensoryLockerRoom' => $result->getHandicapAccessSensoryLockerRoom(),
                    'handicapAccessMobilityLockerRoom' => $result->getHandicapAccessMobilityLockerRoom(),
                    'handicapAccessMobilitySwimmingPool' => $result->getHandicapAccessMobilitySwimmingPool(),
                    'handicapAccessSensorySanitary' => $result->getHandicapAccessSensorySanitary(),
                    'handicapAccessMobilitySanitary' => $result->getHandicapAccessMobilitySanitary(),
                    'facilityName' => $result->getFacilityName(),
                    'facilityAddressNumber' => $result->getAddressNumber(),
                    'facilityAddressStreet' => $result->getAddressStreet(),
                    'idArrondissement' => $result->getIdArrondissement()->getId(),
                    'idSportsFacilityType' => $result->getIdSportsFacilityType()->getId(),
                    'idSportsPractice' => $result->getIdSportsPractice()->getId()
                ]);
            }

            return new JsonResponse($response);

        } else return JsonResponse::fromJsonString('{"message" : "no data found"}');
    }
    public function getAllConcentrationForSelectedPractice(int $id) {

        $query = $this->createQueryBuilder('f')
            ->select('COUNT(f.id) as number, f.idArrondissement')
            ->from('SportsFacility', 'f')
            ->where('f.idSportsPractice = :id')
            ->setParameter('id', $id)
            ->orderBy('f.idArrondissement', 'ASC')
            ->getQuery()
            ->getResult()
        ;

        if ($query) {
            $response = [];
            foreach ($query as $result) {
                array_push($response, [
                    'number' => $result['number'],
                    'idArondissement' => $result->getIdArrondissement()->getId()
                ]);
            }

            return new JsonResponse($response);

        } else return JsonResponse::fromJsonString('{"message" : "no data found for this id"}');
    }

 /*   SELECT COUNT(id) as number, id_arrondissement
FROM sports_facilities
WHERE id_sports_practice (foreign key) = $id

[
    [
        number => 30,
        idArrondissement => 1
    ]
]

puis, il faut récupérer le numéro de l arrondissmernt et sa superficie

SELECT parisArrondissementNumber, surface
FROM arrondissement
WHERE id = id trouvée précédemment

[
    {
        "id": 1,
        "arrondissement number": 2,
        "surface": 80.34
    }
]

Apres : calculer le nombre
[
  {
    "arrondissement": 2,
    "nombre d'établissements": 80
  }
]

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
