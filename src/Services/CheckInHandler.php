<?php

namespace App\Services;
use App\DTO\RunnerPointedDTO;
use App\Entity\Runner;
use App\Entity\Team;
use App\Enum\TeamRole;
use App\Exception\AlreadyCheckedException;
use App\Exception\NotFoundException;
use App\Repository\RunnerRepository;
use App\Repository\TeamRepository;
use App\Repository\TrailRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\ObjectMapper\ObjectMapperInterface;

/** Service of operations and business logic when a chip is check-in by RFID reader. */
class CheckInHandler
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private ObjectMapperInterface  $mapper,
        private RunnerRepository       $runnerRepository,
        private TeamRepository         $teamRepository,
        private TrailRepository        $trailRepository,
        private TimingService          $timingService,
        private LoggerInterface         $logger
    ) {
    }

    /**Looking for the runner either by using chip only OR bib and role.
     * @param string|null $chip ID detected by RFID reader.
     * @param int|null $bib_number Value entered by the user and communicated by the runner.
     * @param TeamRole|null $role Value obtained from TeamRole enum.
     * @return Runner|null
     */
    public function searchRunner (?string $chip = null, ?int $bib_number = null, ?TeamRole $role = null): ?Runner
    {
        // Create two methods searchRunner. One with chip argument, the other one with bib and role
        if ($chip) {
            $runner = $this->runnerRepository->findByChip($chip) ?? throw new NotFoundException();
        }
        elseif ($bib_number != null && $role != null) {
            $runner = $this->runnerRepository->findByBibAndRole($bib_number, $role->value) ?? throw new NotFoundException();
        }
        else $runner = null;

        if (is_null($runner)) {
            throw new NotFoundException;
        }
        return $runner;
    }

    /**Main method of the checkin service that process the algorithm of checkin.
     * Requires that the Runner was already found.
     * @param Runner $runner
     * @param DateTimeImmutable $dateNow
     * @return RunnerPointedDTO
     */
    public function checkIn (Runner $runner, \DateTimeImmutable $dateNow): RunnerPointedDTO
    {
        $dto = new RunnerPointedDTO();
        /** Returns the data to be displayed on web interface or false if no runner was found. */
        $returnableRunner = false;

        $trail = $this->trailRepository->getTrailByRunnerId($runner->getId());
        $calculatedTimed = $this->timingService->computingTime($trail, $dateNow);

        if ($this->isRunnerChecked($runner)){
            throw new AlreadyCheckedException();
        }
        $runnerChecked = $this->checkSpecifiedRunner($runner, $calculatedTimed);

        $returnableRunner = $this->mapper->map($runner, $dto);
        $dto->trail = $trail?->getName();

        $team = $this->setTimeToTeam($runnerChecked);
        if ($team) $dto->final_time = $team?->getFinalTime();

        return $returnableRunner;
    }

    /**Check that the runner hasn't been checkin by verifying if his time is already set.
     * @param Runner $runnerToCheck
     * @return bool - true if the Runner is already checked;
     * - false if the Runner was not checked, so we can process the algorithm.
     */
    public function isRunnerChecked (Runner $runnerToCheck) : bool
    {
        if ($runnerToCheck->getPersonalTime() !== null) return true;
        else  return false;
    }

    /**Check the runner by setting its personal time value.
     *
     * @param Runner $runnerFound
     * @param DateTimeImmutable $timedRun
     * @return Runner|null
     */
    public function checkSpecifiedRunner (Runner $runnerFound, DateTimeImmutable $timedRun): ?Runner
    {
        $runnerFound->setPersonalTime($timedRun);
        $this->entityManager->persist($runnerFound);
        $this->entityManager->flush();

        return $runnerFound;
    }

    /**Set the time of the team only if all members have arrived.
     * @param Runner $runnerPointed
     * @return Team|null
     */
    public function setTimeToTeam (Runner $runnerPointed) : ?Team // ou bool
    {
        $teamMembers = $this->runnerRepository->countRemainingTeamMembersByBibNumber($runnerPointed, true);

        if ($teamMembers === 0) { // means that no one members are excepted, and we can set the time
            $currentTeam = $this->teamRepository->findByFK($runnerPointed->getFkTeamId());
            $currentTeam->setFinalTime($runnerPointed->getPersonalTime());
            $this->entityManager->persist($currentTeam);
            $this->entityManager->flush();
            return $currentTeam;
        }
        else {
            return null; // if there are any team members left, we not set final time
        }
    }
}