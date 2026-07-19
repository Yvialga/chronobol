<?php

namespace App\Repository;

use App\Entity\Runner;
use App\Entity\Trail;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Trail>
 */
class TrailRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Trail::class);
    }

    public function findByEvent(string $eventSlug) : array
    {
        return $this->createQueryBuilder('t')
            ->where('t.fk_event_id = :eventSlug')
            ->setParameter('eventSlug', $eventSlug)
            ->getQuery()
            ->getResult();

    }

    /**
     * @param int $runnerId
     * @return Trail|null
     */
    public function getTrailByRunnerId (int $runnerId): ?Trail {
        // DQL prefers to query builder because Entities are not all build with inversed by properties
        $dql = <<<DQL
            SELECT trail
            FROM App\Entity\Trail AS trail
            JOIN App\Entity\Runner AS runner
            JOIN runner.fk_team_id AS team
            JOIN team.fk_trail_id AS trailId
            WHERE runner.id = :runnerId
            AND trail.id = trailId
            DQL;

        return $this->getEntityManager()
            ->createQuery($dql)
            ->setParameter('runnerId', $runnerId)
            ->getOneOrNullResult();
    }
}
