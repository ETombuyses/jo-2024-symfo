<?php

namespace App\Repository;

use App\Entity\OlympicEvent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @method OlympicEvent|null find($id, $lockMode = null, $lockVersion = null)
 * @method OlympicEvent|null findOneBy(array $criteria, array $orderBy = null)
 * @method OlympicEvent[]    findAll()
 * @method OlympicEvent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OlympicEventRepositoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OlympicEvent::class);
    }

    public function getAll() {
        $response = [];
        $results = $this->findAll();

        if ($results) {
            foreach ($results as $result) {
                array_push($response, [
                    'id' => $result->getId(),
                    'eventName' => $result->getEventName(),
                    'eventPlace' => $result->getEventPlace(),
                    'date' => $result->getDate(),
                    'idArrondissement' => $result->getIdArrondissement()->getId(),
                    'idSportsPractice' => $result->getIdSportsPractice()->getId(),
                ]);
            }

            return new JsonResponse($response);

        } else return JsonResponse::fromJsonString('{"message" : "no data found"}');
    }

    // /**
    //  * @return OlympicEvent[] Returns an array of OlympicEvent objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?OlympicEvent
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
