<?php

namespace App\Repository;

use App\Entity\OlympicEvent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

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

    public function getAllOlympicSportsOfTheDay(string $date) :array {
        $qb = $this->createQueryBuilder('o');
        $qb->select('s.id, s.practice, s.imageName')
            ->innerJoin('o.idSportsPractice', 's','WITH', 's.id = o.idSportsPractice')
            ->where('o.date = :date')
            ->setParameter('date', $date)
            ->distinct();

        $query = $qb->getQuery();
        $result = $query->getResult();
        return $result;

//////////// former code that works 100% ///////////////////////////////
//        $conn = $this->getEntityManager()
//            ->getConnection();
//
//        $sql = "SELECT DISTINCT s.id, s.practice, s.image_name
//                FROM sports_practice s
//                INNER JOIN olympic_event o ON s.id = o.id_sports_practice
//                WHERE o.date = :date";
//        $stmt = $conn->prepare($sql);
//        $stmt->bindValue("date", $date);
//        $stmt->execute();
//        $result = $stmt->fetchAll();
//        return $result;
    }
}
