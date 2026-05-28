<?php

namespace App\DataFixtures;

use App\Entity\Runner;
use App\Entity\Team;
use App\Enum\GenderEnum;
use App\Enum\StatusEnum;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class RunnerFixtures extends Fixture implements DependentFixtureInterface
{
    /**
     * @throws \DateInvalidOperationException
     */
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');

        /** Array of all teams. Each team have two runners. Index of runner data in the array ([][]) :
         * 0. age
         * 1. gender
         * 2. bibNumber
         * 3. chipId
         * 4. isCaptain
         * 5. isUnderage
         * 6. parental Consent
         * 7. isValidate
         */
        $data = [
            TeamFixtures::TEAM1 => [ // Team competing on discovery bowl. Chip ½ works
                [
                    (new \DateTimeImmutable())->sub(new \DateInterval('P12Y')), //age
                    GenderEnum::man,
                    1, //bibnumber
                    '0006486741', // chipId, works
                    false, // captain
                    true,// isUnderage (< 18 year old)
                    true, // parentalContent
                    false // isValidate : by default = no

                ],
                [
                    (new \DateTimeImmutable())->sub(new \DateInterval('P31Y')),
                    GenderEnum::man,
                    1,
                    '0006214799', // don't work
                    true,
                    false,
                    false,
                    false
                ]
            ],
            TeamFixtures::TEAM2 => [ // Team competing on discovery bowl with invalid parental consent
                [
                    (new \DateTimeImmutable())->sub(new \DateInterval('P13Y')), //age
                    GenderEnum::man,
                    2, //bibnumber
                    '0006790199', // chipId, don't work
                    false, // captain
                    true,// isUnderage (< 18 year old)
                    false, // parentalContent
                    false// isValidate : by default = no

                ],
                [
                    (new \DateTimeImmutable())->sub(new \DateInterval('P29Y')),
                    GenderEnum::woman,
                    2,
                    '0006364399', // don't work
                    true,
                    false,
                    false,
                    false
                ]
            ],
            TeamFixtures::TEAM3 => [ // Team competing on small bowl
                [
                    (new \DateTimeImmutable())->sub(new \DateInterval('P14Y')), //age
                    GenderEnum::man,
                    3, //bibnumber
                    '0006755499', // chipId, don't work
                    false, // captain
                    true,// isUnderage (< 18 year old)
                    true, // parentalContent
                    false // isValidate : by default = no

                ],
                [
                    (new \DateTimeImmutable())->sub(new \DateInterval('P25Y')),
                    GenderEnum::man,
                    3,
                    '0006400199', // don't work
                    true,
                    false,
                    false,
                    false
                ]
            ],
            TeamFixtures::TEAM4 => [ // Team competing on small bowl
                [
                    (new \DateTimeImmutable())->sub(new \DateInterval('P18Y')), //age
                    GenderEnum::woman,
                    4, //bibnumber
                    '0006280199', // chipId, don't work
                    true, // captain
                    false,// isUnderage (< 18 year old)
                    false, // parentalContent
                    false // isValidate : by default = no

                ],
                [
                    (new \DateTimeImmutable())->sub(new \DateInterval('P18Y')),
                    GenderEnum::woman,
                    4,
                    '0006499999', // don't work
                    false,
                    false,
                    false,
                    false
                ]
            ],
            TeamFixtures::TEAM5 => [ // Team competing on small bowl
                [
                    (new \DateTimeImmutable())->sub(new \DateInterval('P21Y')), //age
                    GenderEnum::man,
                    5, //bibnumber
                    '0006569099', // chipId, don't work
                    true, // captain
                    false,// isUnderage (< 18 year old)
                    false, // parentalContent
                    false // isValidate : by default = no

                ],
                [
                    (new \DateTimeImmutable())->sub(new \DateInterval('P27Y')),
                    GenderEnum::woman,
                    5,
                    '0006734999', // don't work
                    false,
                    false,
                    false,
                    false
                ]
            ],
            TeamFixtures::TEAM6 => [ // Team competing on small bowl
                [
                    (new \DateTimeImmutable())->sub(new \DateInterval('P34Y')), //age
                    GenderEnum::man,
                    6, //bibnumber
                    '0006017999', // chipId, don't work
                    true, // captain
                    false,// isUnderage (< 18 year old)
                    false, // parentalContent
                    false // isValidate : by default = no

                ],
                [
                    (new \DateTimeImmutable())->sub(new \DateInterval('P36Y')),
                    GenderEnum::man,
                    6,
                    '0006699999', // don't work
                    false,
                    false,
                    false,
                    false
                ]
            ],
            TeamFixtures::TEAM7 => [ // Team competing on large bowl. Chip works
                [
                    (new \DateTimeImmutable())->sub(new \DateInterval('P40Y')), //age
                    GenderEnum::man,
                    7, //bibnumber
                    '0006390192', // chipId, works
                    true, // captain
                    false,// isUnderage (< 18 year old)
                    false, // parentalContent
                    false // isValidate : by default = no

                ],
                [
                    (new \DateTimeImmutable())->sub(new \DateInterval('P24Y')),
                    GenderEnum::man,
                    7,
                    '0006255470', // works
                    false,
                    false,
                    false,
                    false
                ]
            ],
            TeamFixtures::TEAM8 => [ // Team competing on large bowl
                [
                    (new \DateTimeImmutable())->sub(new \DateInterval('P39Y')), //age
                    GenderEnum::man,
                    8, //bibnumber
                    '0006307499', // chipId, don't work
                    true, // captain
                    false,// isUnderage (< 18 year old)
                    false, // parentalContent
                    false // isValidate : by default = no
                ],
                [
                    (new \DateTimeImmutable())->sub(new \DateInterval('P33Y')),
                    GenderEnum::woman,
                    8,
                    '0006211999', // don't work
                    false,
                    false,
                    false,
                    false
                ]
            ],
            TeamFixtures::TEAM9 => [ // Team competing on large bowl
                [
                    (new \DateTimeImmutable())->sub(new \DateInterval('P26Y')), //age
                    GenderEnum::man,
                    9, //bibnumber
                    '0006127699', // chipId, don't work
                    true, // captain
                    false,// isUnderage (< 18 year old)
                    false, // parentalContent
                    false // isValidate : by default = no

                ],
                [
                    (new \DateTimeImmutable())->sub(new \DateInterval('P28Y')),
                    GenderEnum::man,
                    9,
                    '0006393899', // don't work
                    false,
                    false,
                    false,
                    false
                ]
            ],
            TeamFixtures::TEAM10 => [ // Team competing on large bowl
                [
                    (new \DateTimeImmutable())->sub(new \DateInterval('P31Y')), //age
                    GenderEnum::woman,
                    10, //bibnumber
                    '0006038899', // chipId, don't work
                    true, // captain
                    false,// isUnderage (< 18 year old)
                    false, // parentalContent
                    false // isValidate : by default = no
                ],
                [
                    (new \DateTimeImmutable())->sub(new \DateInterval('P31Y')),
                    GenderEnum::woman,
                    10,
                    '0006474199', // don't work
                    false,
                    false,
                    false,
                    false
                ]
            ]
        ];
        foreach ($data as $teamReference => $membersReference) {
            foreach ($membersReference as $member) {

                if ($member[1] === GenderEnum::woman) $firstname = $faker->firstNameFemale();
                else $firstname = $faker->firstNameMale();

                $runner = new Runner();
                $runner->setFirstname($firstname);
                $runner->setLastname($faker->lastName());
                $runner->setAge($member[0]);
                $runner->setGender($member[1]);
                $runner->setEmail($faker->safeEmail());
                $runner->setBibNumber($member[2]);
                $runner->setChipId($member[3]);
                $runner->setIsCaptain($member[4]);
                $runner->setIsUnderage($member[5]);
                $runner->setMedicalCertificate("https://jsonplaceholder.typicode.com/photos/1");
                $runner->setParentalConsent($member[6]);
                $runner->setIsValidate($member[7]);
                $runner->setStatus($faker->randomElement([
                    StatusEnum::invalid,
                    StatusEnum::register
                ]));
                $runner->setUpdatedAt(new \DateTimeImmutable('now'));
                $runner->setFkTeamId($this->getReference($teamReference, Team::class));
                $manager->persist($runner);
            }
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [TeamFixtures::class];
    }
}
