<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;
    public const NB_COMPANY = 5;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }
    public function load(ObjectManager $manager): void
    {
        $randomUser = new User();
        $randomUser->setRoles(['ROLE_EMPLOYEE']);
        $randomUser->setEmail('user@gmail.com');
        $randomUser->setFirstname('Chuck');
        $randomUser->setLastname('Norris');
        $randomUser->setPhoneNumber('0689324523');
        $password = $this->passwordHasher->hashPassword($randomUser, 'password');
        $randomUser->setPassword($password);
        $manager->persist($randomUser);

        $admin = new User();
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setEmail('admin@aws.com');
        $admin->setFirstname('The Real');
        $admin->setLastname('Trivet');
        $admin->setPhoneNumber('0665234512');
        $password = $this->passwordHasher->hashPassword($admin, 'admin');
        $admin->setPassword($password);
        $manager->persist($admin);

        $manager->flush();
    }
}
