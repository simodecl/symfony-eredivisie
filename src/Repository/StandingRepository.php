<?php

namespace App\Repository;

use App\Entity\Standing;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Standing>
 *
 * @method Standing|null find($id, $lockMode = null, $lockVersion = null)
 * @method Standing|null findOneBy(array $criteria, array $orderBy = null)
 * @method Standing[]    findAll()
 * @method Standing[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StandingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Standing::class);
    }

//    /**
//     * @return Standing[] Returns an array of Standing objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Standing
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
