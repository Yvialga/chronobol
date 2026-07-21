<?php

namespace App\Repository;

use App\Entity\Runner;
use App\Entity\Team;
use App\Entity\Trail;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Team>
 */
class TeamRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Team::class);
    }

    /**Get all teams
     * @param int $eventId
     * @return array<Team>
     */
    public function findAllByEvent (int $eventId) : array
    {
        $dql = <<<DQL
            SELECT team
            FROM App\Entity\Team team
            JOIN team.fk_trail_id trail
            JOIN trail.fk_event_id event
            WHERE event.id = :eventId
            DQL;

        return $this->getEntityManager()
            ->createQuery($dql)
            ->setParameter('eventId', $eventId)
            ->getResult();
    }

    /**find all with their trails.
     * @param int $eventId
     * @return array<int, Team, Trail>
     */
    public function findAllWithTrails (int $eventId) : array
    {
        $dql = <<<DQL
            SELECT team, trail.name
            FROM App\Entity\Team team
            JOIN team.fk_trail_id trail
            JOIN trail.fk_event_id event
            WHERE event.id = :eventId
            DQL;

        return $this->getEntityManager()
            ->createQuery($dql)
            ->setParameter('eventId', $eventId)
            ->getResult();
    }

    public function findOneByEvent (int $eventId, int $id) : ?Team
    {
        return $this->createQueryBuilder('t')
            ->where('t.event = :event')
            ->andWhere('t.id = :id')
            ->setParameter('id', $id)
            ->setParameter('event', $eventId)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @param int $fk
     * @return Team
     */
    public function findByFK(Team $fk) : Team
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.id = :fk')
            ->setParameter('fk', $fk)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @param Trail $trail
     * @return array<int, Team>
     */
    public function findOrderByTime (Trail $trail) : array
    {
        $dql = <<<DQL
            SELECT team
            FROM App\Entity\Team team
            JOIN team.fk_trail_id trail
            WHERE trail.id = :trailId
            ORDER BY team.final_time ASC
            DQL;

        return $this->getEntityManager()
            ->createQuery($dql)
            ->setParameter('trailId', $trail->getId())
            ->getResult();
    }
}
