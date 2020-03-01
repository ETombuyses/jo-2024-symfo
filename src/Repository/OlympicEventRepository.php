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
        $qb->select('p.id, p.practice, p.imageName')
            ->innerJoin('o.idSportsPractice', 'p','WITH', 'p.id = o.idSportsPractice')
            ->where('o.date = :date')
            ->setParameter('date', $date)
            ->distinct();

        $query = $qb->getQuery();
        $result = $query->getResult();
        return $result;
    }

    public function getArrondissementCurrentEvents(int $arrondissement, string $date) {

        // get the sport practice name and image of an olympic sport occuring in a given arrondissement on a given date
        $qb = $this->createQueryBuilder('o');
        $qb->select('p.practice, p.imageName, o.eventPlace')
            ->innerJoin('o.idSportsPractice', 'p','WITH', 'p.id = o.idSportsPractice')
            ->where('o.date = :date')
            ->andWhere('o.idArrondissement = :id_arrondissement')
            ->setParameter('date', $date)
            ->setParameter('id_arrondissement', $arrondissement);

        $query = $qb->getQuery();
        $result = $query->getResult();
        return $result;
    }


    public function getAllOlympicsPractices() {
        $qb = $this->createQueryBuilder('o');
        $qb->select('p.id, p.practice, p.imageName')
            ->innerJoin('o.idSportsPractice', 'p','WITH', 'p.id = o.idSportsPractice')
            ->distinct();

        $query = $qb->getQuery();
        $result = $query->getResult();
        return $result;
    }


    public function getAllOlympicsPracticesByDate(string $date) {
        $qb = $this->createQueryBuilder('o');
        $qb->select('p.id, p.practice, p.imageName')
            ->innerJoin('o.idSportsPractice', 'p','WITH', 'p.id = o.idSportsPractice')
            ->where('o.date = :date')
            ->setParameter('date', $date)
            ->distinct();

        $query = $qb->getQuery();
        $result = $query->getResult();
        return $result;
    }

}
