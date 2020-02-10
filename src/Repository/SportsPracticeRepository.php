<?php

namespace App\Repository;

use App\Entity\SportsPractice;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @method SportsPractice|null find($id, $lockMode = null, $lockVersion = null)
 * @method SportsPractice|null findOneBy(array $criteria, array $orderBy = null)
 * @method SportsPractice[]    findAll()
 * @method SportsPractice[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SportsPracticeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SportsPractice::class);
    }

    public function getAll() {
        $response = [];
        $results = $this->findAll();

        if ($results) {
            foreach ($results as $result) {
                $sports_families_array = [];
                $sports_families = $result->getIdSportsFamily();
                foreach($sports_families as $sports_family) {
                    array_push($sports_families_array, $sports_family->getId());
                }
                array_push($response, [
                    'id' => $result->getId(),
                    'practice' => $result->getPractice(),
                    'imageName' => $result->getImageName(),
                    'idsSportsFamilies' => $sports_families_array
                ]);
            }

            return new JsonResponse($response);

        } else return JsonResponse::fromJsonString('{"message" : "no data found"}');
    }

    // /**
    //  * @return SportsPractice[] Returns an array of SportsPractice objects
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
    public function findOneBySomeField($value): ?SportsPractice
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
