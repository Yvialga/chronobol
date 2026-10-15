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

    /**
     * @param int $bib
     * @param int $role This may constitute a *technical debt*. In fact, if we use Postgre, PGSQL accepts "true" value, but we pass it 0 or 1 depending on TeamRole enum
     * @return Runner|null
     */
    public function findByBibAndRole (int $bib, int $role): ?Runner
    {
        // We check both bib and is_captain because in the event, the two members of one team have the same bib.
        return $this->createQueryBuilder('runner')
            ->andWhere('runner.bib_number = :bib')
            ->andWhere('runner.is_captain = :role')
            ->setParameter('bib', $bib)
            ->setParameter('role', $role)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /** Get all members of a team by the bib number. Parameter excludeRunner is optional and is must be used to exclude a specified Runner
     * @param Runner $runner - to get the bib and the id for exclude the runner provides.
     * @param bool $excludedRunner
     * @return int
     */
    public function countRemainingTeamMembersByBibNumber (Runner $runner, bool $excludedRunner = false) : int
    {
        $qb = $this->createQueryBuilder('r')
            ->select('COUNT(r.bib_number)')
            ->where('r.bib_number = :bib')
            ->setParameter('bib', $runner->getBibNumber())
            ->groupBy('r.bib_number');

        if ($excludedRunner) {
            $qb
                ->andWhere('r.id != :excludedRunner')
                ->setParameter('excludedRunner', $runner->getId())
                ->andWhere('r.personal_time is null');
        }
        $count = $qb->getQuery()
                    ->getOneOrNullResult();
        // 1 because query result index begin to 1, not 0
        return $count[1];
    }
}
