<?php

namespace App\Repository;

use App\Entity\SportsFamily;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;

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

    public function getAll() {
        $response = [];
        $results = $this->findAll();

        if ($results) {
            foreach ($results as $result) {
                $practices_array = [];
                $practices = $result->getIdPractice();
                foreach($practices as $practice) {
                    array_push($practices_array, $practice->getId());
                }
                array_push($response, [
                    'id' => $result->getId(),
                    'sportsFamilyName' => $result->getSportsFamilyName(),
                    'idsPractices' => $practices_array
                ]);
            }

            return new JsonResponse($response);

        } else return JsonResponse::fromJsonString('{"message" : "no data found"}');
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
