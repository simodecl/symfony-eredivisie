<?php

namespace App\Repository;

use App\Entity\Player;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * The Player Repository.
 *
 * @extends ServiceEntityRepository<Player>
 *
 * @method Player|null find($id, $lockMode = null, $lockVersion = null)
 * @method Player|null findOneBy(array $criteria, array $orderBy = null)
 * @method Player[]    findAll()
 * @method Player[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlayerRepository extends ServiceEntityRepository {

  /**
   * PlayerRepository constructor.
   *
   * @param \Doctrine\Persistence\ManagerRegistry $registry
   *   The registry.
   */
  public function __construct(ManagerRegistry $registry) {
    parent::__construct($registry, Player::class);
  }

  /**
   * Find all players except the ones with the given IDs.
   *
   * @param int[] $ids
   *   The IDs of the players to exclude.
   *
   * @return \App\Entity\Player[]
   *   The players.
   */
  public function findAllExcept(array $ids): array {
    $qb = $this->createQueryBuilder('p');
    $qb->where($qb->expr()->notIn('p.externalId', $ids));

    return $qb->getQuery()->getResult();
  }

}
