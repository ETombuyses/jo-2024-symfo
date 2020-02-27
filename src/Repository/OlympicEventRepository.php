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

    public function getAllOlympicSportsOfTheDay(string $date) {
        $qb = $this->createQueryBuilder('o');
        $qb->select('s.id, s.practice, s.imageName')
            ->innerJoin('o.idSportsPractice', 's','WITH', 's.id = o.idSportsPractice')
            ->where('o.date = :date')
            ->setParameter('date', $date)
            ->distinct();

        $query = $qb->getQuery();
        $result = $query->getResult();
        return $result;
    }
}
