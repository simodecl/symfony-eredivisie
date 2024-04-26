<?php

namespace App\Repository;

use App\Entity\Coach;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * The Coach Repository.
 *
 * @extends ServiceEntityRepository<Coach>
 *
 * @method Coach|null find($id, $lockMode = null, $lockVersion = null)
 * @method Coach|null findOneBy(array $criteria, array $orderBy = null)
 * @method Coach[]    findAll()
 * @method Coach[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CoachRepository extends ServiceEntityRepository {

  /**
   * CoachRepository constructor.
   *
   * @param \Doctrine\Persistence\ManagerRegistry $registry
   *   The registry.
   */
  public function __construct(ManagerRegistry $registry) {
    parent::__construct($registry, Coach::class);
  }

  /**
   * Find all coaches except the ones with the given IDs.
   *
   * @param int[] $ids
   *   The IDs of the coaches to exclude.
   *
   * @return Coach[]
   *   The coaches.
   */
  public function findAllExcept(array $ids): array {
    $qb = $this->createQueryBuilder('c');
    $qb->where($qb->expr()->notIn('c.externalId', $ids));

    return $qb->getQuery()->getResult();
  }

}
