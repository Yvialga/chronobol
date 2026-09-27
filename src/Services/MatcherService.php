<?php

namespace App\Services;

use App\DTO\RunnerPointedDTO;
use App\Entity\Runner;
use App\Repository\TrailRepository;
use Symfony\Component\ObjectMapper\ObjectMapperInterface;

/**Its role is to serve as the intermediate between CheckIn controller and CheckInHandler
 * to be not repeated by the two forms.
 */
class MatcherService
{
    public function __construct(
        private ObjectMapperInterface $mapper,
        private CheckInHandler $checkInHandler,
        private TrailRepository $trailRepository,
    )
    { }

    /**Separate Logic from checkin controller to be used both manual and automatic form
     * @param Runner $runner
     * @param \DateTimeImmutable $dateNow
     * @return RunnerPointedDTO Object to return to the frontend
     */
    public function checkInLogic (Runner $runner, \DateTimeImmutable $dateNow): RunnerPointedDTO
    {
        $dto = new RunnerPointedDTO();
        /** Returns the data to be displayed on web interface or false if no runner was found. */
        $returnableRunner = false;
        $trail = $this->trailRepository->getTrailByRunnerId($runner->getId());
        $runnerFound = $this->checkInHandler->checkRunner($runner, $dateNow, $trail);
        $team = $this->checkInHandler->setTimeToTeam($runnerFound);

        $returnableRunner = $this->mapper->map($runner, $dto);
        $dto->final_time = $team?->getFinalTime();
        $dto->trail = $trail?->getName();

        return $returnableRunner;
    }
}