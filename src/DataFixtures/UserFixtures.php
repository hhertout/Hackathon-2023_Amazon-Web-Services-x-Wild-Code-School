<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Faker\Factory;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;
    public const NB_COMPANY = 6;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < self::NB_COMPANY; $i++) {
            $companyExecutive = new User();
            $companyExecutive->setFirstname($faker->firstName());
            $companyExecutive->setLastname($faker->lastName());
            $companyExecutive->setPhoneNumber('0689324523');
            $companyExecutive->setEmail('company_' . $i . '@gmail.com');
            $password = $this->passwordHasher->hashPassword($companyExecutive, 'password');
            $companyExecutive->setPassword($password);
            $companyExecutive->setCompany($this->getReference('company_' . $i));
            $manager->persist($companyExecutive);
        }

        $randomUser = new User();
        $randomUser->setRoles(['ROLE_EMPLOYEE']);
        $randomUser->setEmail('user@gmail.com');
        $randomUser->setFirstname('Junior');
        $randomUser->setLastname('Trivet');
        $randomUser->setPhoneNumber('0689324523');
        $password = $this->passwordHasher->hashPassword($randomUser, 'password');
        $randomUser->setPassword($password);
        $randomUser->setCompany($this->getReference('company_' . $faker->numberBetween(0, 5)));
        $manager->persist($randomUser);

        $admin = new User();
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setEmail('admin@aws.com');
        $admin->setFirstname('Chuck');
        $admin->setLastname('Norris');
        $admin->setPhoneNumber('0665234512');
        $password = $this->passwordHasher->hashPassword($admin, 'admin');
        $admin->setPassword($password);
        $admin->setCompany($this->getReference('company_0'));
        $manager->persist($admin);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [

            CompanyFixtures::class,

        ];
    }
}
