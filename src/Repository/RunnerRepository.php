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

    /** Return only the bib of the runner starting from chip id.
     * @param string $chip chip id to be searched for in the indexes
     * @return Runner|null
     */
    public function findByChip (string $chip): ?Runner
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.chip_id = :chip')
            ->setParameter('chip', $chip)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /** Get all members of a team by the bib number. Parameter excludeRunner is optional and is must be used to exclude a specified Runner
     * @param int $bib
     * @param Runner|null $excludedRunner
     * @return array<int, Runner>
     */
    public function findTeamMembersByBibNumber (int $bib, ?Runner $excludedRunner = null) : array
    {
        $qb = $this->createQueryBuilder('r')
            ->where('r.bib_number = :bib')
            ->setParameter('bib', $bib);

        if ($excludedRunner) {
            $qb
                ->andWhere('r.id != :excludedRunner')
                ->setParameter('excludedRunner', $excludedRunner->getId());
        }

        return $qb
            ->getQuery()
            ->getResult();
    }
}
