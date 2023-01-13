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
    public const NB_COMPANY = 7;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < self::NB_COMPANY; $i++) {
            $companyExecutive = new User();
            $companyExecutive->setRoles(['ROLE_COMPANY']);
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
        $this->addReference('randomUser_1', $randomUser);
        $manager->persist($randomUser);

        $randomReserver = new User();
        $randomReserver->setRoles(['ROLE_EMPLOYEE']);
        $randomReserver->setEmail('previousRenter@gmail.com');
        $randomReserver->setFirstname('Vin');
        $randomReserver->setLastname('Diesel');
        $randomReserver->setPhoneNumber('0689324523');
        $password = $this->passwordHasher->hashPassword($randomReserver, 'password');
        $randomReserver->setPassword($password);
        $randomReserver->setCompany($this->getReference('company_' . $faker->numberBetween(0, 5)));
        $this->addReference('randomReserver_1', $randomReserver);
        $manager->persist($randomReserver);


        //L'entreprise pour la démo
        $demoCompany = new User();
        $demoCompany->setRoles(['ROLE_COMPANY']);
        $demoCompany->setEmail('amazon@gmail.com');
        $demoCompany->setFirstname('Jeff');
        $demoCompany->setLastname('Bezos');
        $demoCompany->setPhoneNumber('0682253698');
        $password = $this->passwordHasher->hashPassword($demoCompany, 'password');
        $demoCompany->setPassword($password);
        $demoCompany->setCompany($this->getReference('company_2'));
        $this->addReference('demo_company', $demoCompany);
        $manager->persist($demoCompany);

        //Le user pour la démo : facebook
        $demoEmployee = new User();
        $demoEmployee->setRoles(['ROLE_EMPLOYEE']);
        $demoEmployee->setEmail('instagram@gmail.com');
        $demoEmployee->setFirstname('Mark');
        $demoEmployee->setLastname('Zuckerberg');
        $demoEmployee->setPhoneNumber('0683453728');
        $password = $this->passwordHasher->hashPassword($demoEmployee, 'password');
        $demoEmployee->setPassword($password);
        $demoEmployee->setCompany($this->getReference('company_11'));
        $this->addReference('demo_employee', $demoEmployee);
        $manager->persist($demoEmployee);

        $admin = new User();
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setEmail('admin@aws.com');
        $admin->setFirstname('Chuck');
        $admin->setLastname('Norris');
        $admin->setPhoneNumber('0665234512');
        $password = $this->passwordHasher->hashPassword($admin, 'admin');
        $admin->setPassword($password);
        $admin->setCompany($this->getReference('company_8'));
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
