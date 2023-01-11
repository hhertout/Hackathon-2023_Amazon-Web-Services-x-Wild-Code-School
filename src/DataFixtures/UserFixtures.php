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
        $randomUser->setEmail('user@gmail.com');
        $password = $this->passwordHasher->hashPassword($randomUser, 'password');
        $randomUser->setPassword($password);
        $manager->persist($randomUser);

        for ($i = 0 ; $i < self::NB_COMPANY ; $i++){
            $company = new User();
            $company->setEmail('company_' . $i . '@gmail.com');
            $password = $this->passwordHasher->hashPassword($company, 'password');
            $company->setPassword($password);
            $manager->persist($company);
        }

        $admin = new User();
        $admin->setEmail('admin@aws.com');
        $password = $this->passwordHasher->hashPassword($admin, 'admin');
        $admin->setPassword($password);
        $manager->persist($admin);

        $manager->flush();
    }
}
