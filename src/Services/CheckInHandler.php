<?php

namespace App\Services;
use App\Entity\Runner;
use App\Entity\Team;
use App\Entity\Trail;
use App\Enum\TeamRole;
use App\Repository\RunnerRepository;
use App\Repository\TeamRepository;
use App\Repository\TrailRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

/** Service of operations and business logic when a chip is check-in by RFID reader. */
class CheckInHandler
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private TrailRepository        $trailRepository,
        private TeamRepository         $teamRepository,
        private RunnerRepository       $runnerRepository,
        private TimingService          $timingService,
        private LoggerInterface        $logger,
    ) {
    }

    /**Looking for the runner either by using chip only or bib with role.
     * @param string|null $chip ID detected by RFID reader.
     * @param int|null $bib_number Value entered by the user and communicated by the runner.
     * @param TeamRole|null $role Value obtained from TeamRole enum.
     * @return Runner|null
     */
    public function searchRunner (?string $chip = null, ?int $bib_number = null, ?TeamRole $role = null): ?Runner
    {
        // Create two methods searchRunner. One with chip argument, the other one with bib and role
        if ($chip) $runner = $this->runnerRepository->findByChip($chip);
        elseif ($bib_number != null && $role != null) $runner = $this->runnerRepository->findByBibAndRole($bib_number, $role->value);
        else $runner = null;

        if (is_null($runner)) {
            return null;
        }
//      Here, we check that the runner don't already have a defined time before to continue
//        elseif ($runner->getPersonalTime() !== null) { //TODO to uncomment for prod
//            return null; // TODO HERE Throw an error to catch in controller
//        }

        return $runner;
    }

    /**Check the runner by setting its personal time value.
     *
     * @param Runner $runnerFound
     * @param DateTimeImmutable $dateNow To calculate time
     * @param Trail $trail
     * @return Runner|null
     */
    public function checkRunner (Runner $runnerFound, DateTimeImmutable $dateNow, Trail $trail): ?Runner
    {
        $timedRun = $this->timingService->computingTime($trail, $dateNow);

        $runnerFound->setPersonalTime($timedRun);
        $this->entityManager->persist($runnerFound);
        $this->entityManager->flush();

        return $runnerFound;
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