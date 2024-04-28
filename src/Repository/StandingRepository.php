<?php

namespace App\Repository;

use App\Entity\Standing;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * The Standing Repository.
 *
 * @extends ServiceEntityRepository<Standing>
 *
 * @method Standing|null find($id, $lockMode = null, $lockVersion = null)
 * @method Standing|null findOneBy(array $criteria, array $orderBy = null)
 * @method Standing[]    findAll()
 * @method Standing[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StandingRepository extends ServiceEntityRepository {

    /**
     * StandingRepository constructor.
     *
     * @param \Doctrine\Persistence\ManagerRegistry $registry
     *   The registry.
     */
    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, Standing::class);
    }

    /**
     * Get the top standings.
     *
     * @param int $limit
     *   The number of teams to return.
     *
     * @return \App\Entity\Standing[]
     *   The top three teams.
     */
    public function findTopStandings(int $limit = 3): array {
        $qb = $this->createQueryBuilder('s');
        $qb->orderBy('s.points', 'DESC');
        $qb->setMaxResults($limit);

        return $qb->getQuery()->getResult();
    }

    /**
     * Get the top teams with the most goals scored.
     *
     * @param int $limit
     *   The number of teams to return.
     * @return \App\Entity\Standing[]
     *   The top goal scoring teams.
     */
    public function findTopGoalsFor(int $limit = 5): array {
        $qb = $this->createQueryBuilder('s');
        $qb->orderBy('s.goalsFor', 'DESC');
        $qb->setMaxResults($limit);

        return $qb->getQuery()->getResult();
    }

}
