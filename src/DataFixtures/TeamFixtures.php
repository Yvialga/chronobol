<?php

namespace App\DataFixtures;

use App\Entity\Team;
use App\Entity\Trail;
use App\Enum\CategoryEnum;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class TeamFixtures extends Fixture implements DependentFixtureInterface
{
    public const TEAM1 = "team-1";
    public const TEAM2 = "team-2";
    public const TEAM3 = "team-3";
    public const TEAM4 = "team-4";
    public const TEAM5 = "team-5";
    public const TEAM6 = "team-6";
    public const TEAM7 = "team-7";
    public const TEAM8 = "team-8";
    public const TEAM9 = "team-9";
    public const TEAM10 = "team-10";

    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');

        $discoveryBowl = $this->getReference(TrailFIxtures::DISCOVERY_BOWL, Trail::class);
        $smallBowl = $this->getReference(TrailFIxtures::SMALL_BOWL, Trail::class);
        $largeBowl = $this->getReference(TrailFixtures::LARGE_BOWL, Trail::class);

        /** Trails of each of the 10 teams.
         * The top 2 are competing on discovery bwol,
         * 4 are competing on small bowl,
         * and the last 4 are competing on large bowl
         */
        $trails = [
            [$discoveryBowl, self::TEAM1],
            [$discoveryBowl, self::TEAM2],
            [$smallBowl, self::TEAM3],
            [$smallBowl, self::TEAM4],
            [$smallBowl, self::TEAM5],
            [$smallBowl, self::TEAM6],
            [$largeBowl, self::TEAM7],
            [$largeBowl, self::TEAM8],
            [$largeBowl, self::TEAM9],
            [$largeBowl, self::TEAM10]
        ];

        for ($i = 0; $i < count($trails) ; $i++) {
            $team = new Team();
            $team->setMealCount($faker->numberBetween(2, 6));
            $team->setMemberNumber(2);
            $team->setUpdatedAt(new \DateTimeImmutable('now'));

            // Definition of categories :
            switch ($i) {
                case 0:
                case 2:
                case 5:
                case 6:
                case 8:
                    $team->setCategory(CategoryEnum::man);
                    break;
                case 1:
                case 4:
                case 7:
                    $team->setCategory(CategoryEnum::mixed);
                    break;
                case 3:
                case 9:
                    $team->setCategory(CategoryEnum::woman);
                    break;
            }
            // Switch for paid registration
            switch ($i) {
                // Team has not paid either the registration or the deposit
                case 3:
                    $team->setPaidRegistration(false);
                    $team->setDeposit(false);
                    break;
                // Team has paid their registration but has not paid the deposit
                case 4:
                    $team->setPaidRegistration(true);
                    $team->setDeposit(false);
                    break;
                // Team competing with an electrical bike => they are not ranked
                case 8:
                    $team->setElectricBike(true);
                    break;
                // general cases, i.e. the valid dataset for processing in the rest of the app
                default:
                    $team->setElectricBike(false);
                    $team->setPaidRegistration(true);
                    $team->setDeposit(true);
            }
            $team->setFkTrailId($trails[$i][0]);
            $manager->persist($team);
            $this->addReference($trails[$i][1], $team);
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            TrailFixtures::class
        ];
    }
}
