<?php

namespace App\Tests\Integration\Repository;

use App\Entity\Runner;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class RunnerRepositoryTest extends KernelTestCase
{
    private ?EntityManager $entityManager;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();
        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    public function testCounterOfTeamMembersByBib(): void
    {
        $runnerRepo = $this->entityManager
            ->getRepository(Runner::class);
        $runnerFound = $runnerRepo->findByChip('0006390192'); // chip from fixtures
        $count = $runnerRepo->countRemainingTeamMembersByBibNumber($runnerFound);

        $this->assertIsInt($count, message: $count);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->entityManager->clear();
        $this->entityManager = null;
    }
}
