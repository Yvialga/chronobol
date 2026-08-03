<?php

namespace App\Tests\Integration\Service;

use App\Entity\Runner;
use App\Entity\Trail;
use App\Services\TimingService;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class TimingTest extends KernelTestCase
{
    private ?EntityManager $entityManager;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    public function testReturnTypeOfComputingTimeFromService(): void
    {
        $kernel = self::bootKernel();
        $container = static::getContainer();

        $runner = $this->entityManager->getRepository(Runner::class)->findByChip('0006390192');
        $trail = $this->entityManager->getRepository(Trail::class)->getTrailByRunnerId($runner->getId());
        $timingService = $container->get(TimingService::class);
        $time = $timingService->computingTime($trail, new \DateTimeImmutable('now', new \DateTimeZone('UTC')));

        $this->assertInstanceOf(\DateTimeImmutable::class, $time);
    }
}
