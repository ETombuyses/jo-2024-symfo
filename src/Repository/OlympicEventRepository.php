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

    public function getAll($date) {
        $conn = $this->getEntityManager()
            ->getConnection();

        $sql = "SELECT DISTINCT s.id, s.practice, s.image_name
                FROM sports_practice s
                INNER JOIN olympic_event o ON s.id = o.id_sports_practice
                WHERE o.date = :date";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(":date", $date);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
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
