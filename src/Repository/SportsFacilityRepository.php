<?php

namespace App\Repository;

use App\Entity\SportsFacility;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;

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
