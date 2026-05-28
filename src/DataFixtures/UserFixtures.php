<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture implements FIxtureGroupInterface
{
    public function __construct(private UserPasswordHasherInterface $userPasswordHasher)
    {
    }

    public function load(ObjectManager $manager, ): void
    {
        $user = new User();
        $user->setUsername('user');
        $user->setPassword($this->userPasswordHasher->hashPassword($user, 'mdp-45'));
        $user->setEmail("user@myclub.fr");
        $user->setRoles(['ROLE_USER']);
        $user->setUpdatedAt(new \DateTimeImmutable('now'));
        $manager->persist($user);

        $admin = new User();
        $admin->setUsername('admin');
        $admin->setPassword($this->userPasswordHasher->hashPassword($admin, 'admin-123'));
        $admin->setEmail("admin@myclub.fr");
        $admin->setRoles(['ROLE_ADMIN', 'ROLE_USER']);
        $admin->setUpdatedAt(new \DateTimeImmutable('now'));
        $manager->persist($admin);

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['users'];
    }
}
