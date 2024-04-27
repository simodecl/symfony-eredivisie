<?php

namespace App\Repository;

use App\Entity\FootballMatch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * The FootballMatch Repository.
 *
 * @extends ServiceEntityRepository<FootballMatch>
 *
 * @method FootballMatch|null find($id, $lockMode = null, $lockVersion = null)
 * @method FootballMatch|null findOneBy(array $criteria, array $orderBy = null)
 * @method FootballMatch[]    findAll()
 * @method FootballMatch[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FootballMatchRepository extends ServiceEntityRepository {

  /**
   * FootballMatchRepository constructor.
   *
   * @param \Doctrine\Persistence\ManagerRegistry $registry
   *   The registry.
   */
  public function __construct(ManagerRegistry $registry) {
    parent::__construct($registry, FootballMatch::class);
  }

  /**
   * Find all matches except the ones with the given IDs.
   *
   * @param int[] $ids
   *   The IDs of the matches to exclude.
   *
   * @return \App\Entity\FootballMatch[]
   *   The matches.
   */
  public function findAllExcept(array $ids): array {
    $qb = $this->createQueryBuilder('fm');
    $qb->where($qb->expr()->notIn('fm.externalId', $ids));

    return $qb->getQuery()->getResult();
  }

  /**
   * Find all matches by team id.
   *
   *  Find all matches where a given Team ID is present in either
   *  the home or away team.
   *
   * @param int $teamId
   *   The IDs of the team.
   *
   * @return \App\Entity\FootballMatch[]
   *   The matches.
   */
  public function findAllByTeamId(int $teamId): array {
    // Sort by matchday descending.
    $qb = $this->createQueryBuilder('fm');
    $qb->where($qb->expr()->orX(
      $qb->expr()->eq('fm.homeTeam', $teamId),
      $qb->expr()->eq('fm.awayTeam', $teamId)
    ))->orderBy('fm.matchday', 'DESC');

    return $qb->getQuery()->getResult();
  }

  /**
   * Find the current matchday match by team id.
   *
   * Find the current matchday match where a given Team ID is present in either
   * the home or away team.
   *
   * @param int $teamId
   *   The IDs of the team.
   *
   * @return \App\Entity\FootballMatch
   *   The matches.
   */
  public function findCurrentMatchdayByTeamId(int $teamId): FootballMatch {
    $qb = $this->createQueryBuilder('fm');
    $qb->where($qb->expr()->andX(
      $qb->expr()->orX(
        $qb->expr()->eq('fm.homeTeam', $teamId),
        $qb->expr()->eq('fm.awayTeam', $teamId)
      ),
      $qb->expr()->eq('fm.currentMatchday', 'fm.matchday')
    ));

    return $qb->getQuery()->getSingleResult();
  }

}
