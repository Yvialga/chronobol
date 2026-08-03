<?php

namespace App\Tests\Integration\Service;

use App\Entity\Runner;
use App\Services\CheckInHandler;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/* In progress */
class CheckinTest extends KernelTestCase
{
    private ?EntityManager $entityManager;
    private EntityManagerInterface $manager;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();
        $this->manager = static::getContainer()->get('doctrine')->getManager();

        $container = static::getContainer();
        $em = $container->get('doctrine.orm.entity_manager');
        $userRepository = $em->getRepository(Runner::class);
//        foreach ($userRepository->findAll() as $user) { HERE: reset $runner->Time
//            $em->remove($user);
//        }
    }

    public function testRunnerWasSuccessfullyCheckedIn(): void
    {
        $container = static::getContainer();
        $checkinService = $container->get(CheckInHandler::class);

        $runner = $checkinService->runnerPointer('0006390192');

        $this->assertNotNull($runner->getPersonalTime());
    }

    /* TODO : See to add message depending on the errors of runnerPointer()
    public function testIfRunnerNotExist(): void
    {
        $checkinService = $container->get(CheckInHandler::class);

        $runner = $checkinService->runnerPointer('0007824101');

        $this->assertNull($runner);
    } */

}