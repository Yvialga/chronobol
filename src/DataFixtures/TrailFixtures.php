<?php

namespace App\DataFixtures;

use App\Entity\Event;
use App\Entity\Trail;
use App\Enum\RunStateEnum;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class TrailFixtures extends Fixture implements DependentFixtureInterface
{
    public const LARGE_BOWL = "grand_bol";
    public const SMALL_BOWL = "petit_bol";
    public const DISCOVERY_BOWL = "bol_decouverte";

    public function load(ObjectManager $manager): void
    {
        $trails = [
            ["Grand bol", "épreuve sportive de 42km", (new \DateTimeImmutable('now', new \DateTimeZone('UTC')))->setTime(8, 0), self::LARGE_BOWL],
            ["petit bol", "épreuve sportive de 30km", (new \DateTimeImmutable('now', new \DateTimeZone('UTC')))->setTime(8, 30), self::SMALL_BOWL],
            ["Bol découverte", "épreuve sportive de 13km", (new \DateTimeImmutable('now', new \DateTimeZone('UTC')))->setTime(9, 0), self::DISCOVERY_BOWL]
        ];
        foreach ($trails as $t) {
            $trail = new Trail();
            $trail->setName($t[0]);
            $trail->setStartTime($t[2]);
            $trail->setRunState(RunStateEnum::PLANNED);
            $trail->setDescription($t[1]);
            $trail->setMemberNumber(2);
            $trail->setUpdatedAt(new \DateTimeImmutable('now', new \DateTimeZone('UTC')));
            $trail->setFkEventId($this->getReference(EventFixtures::BOL_2026_REFERENCE, Event::class));
            $this->addReference($t[3], $trail);
            $manager->persist($trail);
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [EventFixtures::class];
    }
}
