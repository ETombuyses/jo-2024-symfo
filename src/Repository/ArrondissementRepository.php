<?php

namespace App\Repository;

use App\Entity\Arrondissement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @method Arrondissement|null find($id, $lockMode = null, $lockVersion = null)
 * @method Arrondissement|null findOneBy(array $criteria, array $orderBy = null)
 * @method Arrondissement[]    findAll()
 * @method Arrondissement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArrondissementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Arrondissement::class);
    }

    public function getAll() {
        $response = [];
        $results = $this->findAll();

        if ($results) {

            foreach ($results as $result) {
                array_push($response, [
                    'id' => $result->getId(),
                    'insee' => $result->getInseeCode(),
                    'name' => $result->getName(),
                    'surfaceKmSquare' => $result->getSurfaceKmSquare(),
                    'parisArrondissementNumber' => $result->getParisArrondissementNumber()
                ]);
            }

            return new JsonResponse($response);

        } else return JsonResponse::fromJsonString('{"message" : "no data found"}');
    }


    // /**
    //  * @return Arrondissement[] Returns an array of Arrondissement objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Arrondissement
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
