<?php

namespace App\Repository;

use App\Entity\Team;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * The Team Repository.
 *
 * @extends ServiceEntityRepository<Team>
 *
 * @method Team|null find($id, $lockMode = null, $lockVersion = null)
 * @method Team|null findOneBy(array $criteria, array $orderBy = null)
 * @method Team[]    findAll()
 * @method Team[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TeamRepository extends ServiceEntityRepository {

  /**
   * TeamRepository constructor.
   *
   * @param \Doctrine\Persistence\ManagerRegistry $registry
   *   The registry.
   */
  public function __construct(ManagerRegistry $registry) {
    parent::__construct($registry, Team::class);
  }

  /**
   * Find all teams except the ones with the given IDs.
   *
   * @param int[] $ids
   *   The IDs of the teams to exclude.
   *
   * @return Team[]
   *   The teams.
   */
  public function findAllExcept(array $ids): array {
    $qb = $this->createQueryBuilder('t');
    $qb->where($qb->expr()->notIn('t.externalId', $ids));

    return $qb->getQuery()->getResult();
  }

}
