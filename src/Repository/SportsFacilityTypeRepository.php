<?php

namespace App\Repository;

use App\Entity\SportsFacilityType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @method SportsFacilityType|null find($id, $lockMode = null, $lockVersion = null)
 * @method SportsFacilityType|null findOneBy(array $criteria, array $orderBy = null)
 * @method SportsFacilityType[]    findAll()
 * @method SportsFacilityType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SportsFacilityTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SportsFacilityType::class);
    }

    public function getAll() {
        $response = [];
        $results = $this->findAll();

        if ($results) {
            foreach ($results as $result) {
                array_push($response, [
                    'id' => $result->getId(),
                    'type' => $result->getType()
                ]);
            }

            return new JsonResponse($response);

        } else return JsonResponse::fromJsonString('{"message" : "no data found"}');
    }

    // /**
    //  * @return SportsFacilityType[] Returns an array of SportsFacilityType objects
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
    public function findOneBySomeField($value): ?SportsFacilityType
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
