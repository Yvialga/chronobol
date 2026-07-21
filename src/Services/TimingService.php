<?php

namespace App\Services;

use App\Entity\Trail;
use App\Enum\RunStateEnum;
use DateTimeImmutable;
use DateTimeZone;
use Doctrine\ORM\EntityManagerInterface;

/** Handle timing of the events. */
class TimingService
{
    public function __construct(
        private EntityManagerInterface $manager
    ) {}

    /**Return the calculated time between now and the Trail start time, provided as an argument.
     * @param Trail $instanceToBeCalculated
     * @param DateTimeImmutable $dateNow
     * @return DateTimeImmutable
     */
    public function computingTime(Trail $instanceToBeCalculated, DateTimeImmutable $dateNow) : DateTimeImmutable
    {
        $startTime = $instanceToBeCalculated->getStartTime()->setTimezone(new \DateTimeZone('UTC'));
        $timeDifference = $startTime->diff($dateNow);
        $placeholderDate = new DateTimeImmutable();
        return $placeholderDate->setTime($timeDifference->h, $timeDifference->i, $timeDifference->s);
    }

    /**Start the timer of a Trail passed as a parameter.
     * @param Trail $trail
     * @return Trail|null
     * @throws \Exception
     */
    public function startTiming(Trail $trail) : ?Trail
    {
        $trail->setStartTime(new DateTimeImmutable('now', new DateTimeZone('UTC')));
        $trail->setRunState(RunStateEnum::IN_PROGRESS);
        $this->manager->persist($trail);
        $this->manager->flush();
        return $trail;
    }
}