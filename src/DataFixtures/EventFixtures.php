<?php

namespace App\DataFixtures;

use App\Entity\Event;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class EventFixtures extends Fixture
{
    public const BOL_2026_REFERENCE = "bol-air-2026";
    public const BOL_2027_REFERENCE = "bol-air-2027";
    public const BOL_2028_REFERENCE = "bol-air-2028";

    public function load(ObjectManager $manager): void
    {
        $events = [
            ["Bol d'air 2026", new \DateTimeImmutable('21-06-2026'), self::BOL_2026_REFERENCE],
            ["Bol d'air 2027", new \DateTimeImmutable('21-06-2027'), self::BOL_2027_REFERENCE],
            ["Bol d'air 2028", new \DateTimeImmutable('21-06-2028'), self::BOL_2028_REFERENCE],
        ];
        foreach ($events as $i) {
            $event = new Event();
            $event->setName($i[0]);
            $event->setDate($i[1]);
            $event->setSlug($i[2]);
            $event->setUpdatedAt(new \DateTimeImmutable('now'));
            $this->addReference($i[2], $event);
            $manager->persist($event);
        }
        $manager->flush();
    }
}
