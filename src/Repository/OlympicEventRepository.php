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
class OlympicEventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OlympicEvent::class);
    }

    public function getAll() {
        $conn = $this->getEntityManager()
            ->getConnection();

        $sql = "SELECT DISTINCT s.id, s.practice, s.image_name, o.date
                FROM sports_practice s
                 INNER JOIN olympic_event o ON s.id = o.id_sports_practice";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $dates = [];
        $events = [];

        foreach ($stmt as $result) {
            if (!in_array($result['date'], $dates)) {
                array_push($dates, $result['date']);
            }

            array_push($events, [
                'id' => $result['id'],
                'practice' => $result['practice'],
                'image' => $result['image_name'],
                'date' => $result['date']
            ]);
        }

        $result = [];

        foreach ($dates as $date) {
            $practices = [];

            foreach ($events as $event) {
                if ($event['date'] === $date) {
                    array_push($practices, [
                        'id' => $event['id'],
                        'practice' => $event['practice'],
                        'image' => $event['image']
                    ]);
                }
            }

            array_push($result, [
                'date' => $date,
                'practices' => $practices
            ]);
        }

        $response = new JsonResponse($result);
        return $response;
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
