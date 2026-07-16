<?php

namespace App\Repository;

use App\Entity\Runner;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Runner>
 */
class RunnerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Runner::class);
    }

    /**
     * @param int $teamId
     * @return array<int, Runner>
     */
    public function findAllByTeam(int $teamId): array
    {
        return $this->createQueryBuilder('runner')
            ->where('runner.fk_team_id = :teamId')
            ->setParameter('teamId', $teamId)
            ->getQuery()
            ->getResult();
    }
}
