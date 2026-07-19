<?php

namespace App\Services;
use App\Entity\Runner;
use App\Entity\Team;
use App\Repository\RunnerRepository;
use App\Repository\TeamRepository;
use App\Repository\TrailRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;

/** Service of operations and business logic when a chip is check-in by RFID reader. */
class CheckInHandler
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private TrailRepository        $trailRepository,
        private TeamRepository         $teamRepository,
        private RunnerRepository       $runnerRepository,
        private TimingService          $timingService,
    ) {
    }

    /**Get a runner from a chip id. Use it for testing only
     * @param string $chipDetected
     * @return Runner|null
     */
    public function handleChipDetection(string $chipDetected): ?Runner
    {
        // function to remove if it is redundant
        // TODO possible operation of SSE TO display the names in UI
        return $this->runnerRepository->findByChip($chipDetected);
    }

    /**
     * EST-ce que que les services injectés doivent être en phpdoc ? ou déplacé dans construct
     * @param $chipDetected
     * @param TimingService $timingService
     * @return void
     */
    public function runnerPointer($chipDetected): ?Runner
    {
        // Initialization here to not lose time with intermediate.s query.ies to the database
        $dateNow = new DateTimeImmutable();
        $currentRunner = $this->runnerRepository->findByChip($chipDetected);

        // Here, we check that the runner don't already have a defined time before to continue
//        if ($currentRunner->getPersonalTime() !== null) { TODO to uncomment
//            return null;
//        }
        $trail = $this->trailRepository->getTrailByRunnerId($currentRunner->getId());

        $timedRun = $this->timingService->computingTime($trail, $dateNow);
        $currentRunner->setPersonalTime($timedRun);
        $this->entityManager->persist($currentRunner);
        $this->entityManager->flush();

        return $currentRunner;
    }

    /**Set the time of the team only if all members have arrived.
     * @param Runner $runnerPointed
     * @return Team|null
     */
    public function setTimeToTeam (Runner $runnerPointed) : ?Team
    {
        $teamMembers = $this->runnerRepository->findTeamMembersByBibNumber($runnerPointed->getBibNumber(), $runnerPointed);
        $missingTimedTeamMembersCounter = 0;
        foreach ($teamMembers as $teamMember) {
            if ($teamMember->getPersonalTime() === null) {
                $missingTimedTeamMembersCounter++;
            }
        }
        if ($missingTimedTeamMembersCounter === 0) { // means that no one members are excepted
            $currentTeam = $this->teamRepository->findByFK($runnerPointed->getFkTeamId());
            $currentTeam->setFinalTime($runnerPointed->getPersonalTime());
            $this->entityManager->persist($currentTeam);
            $this->entityManager->flush();
            return $currentTeam;
        }
        else {
            return null; // if there are any team members left, we not set final time
            // why not return Team ?
        }
    }
}