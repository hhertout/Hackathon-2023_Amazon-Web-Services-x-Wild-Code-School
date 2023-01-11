<?php

namespace App\DataFixtures;

use App\Entity\Company;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CompanyFixtures extends Fixture
{
    public const NB_COMPANY = 6;

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < self::NB_COMPANY; $i++) {
            $company = new Company();
            $company->setName($faker->words(3, true));
            $company->setSIRET($faker->numberBetween(1111111111111, 9999999999999));
            $this->addReference('company_' . $i, $company);

            $manager->persist($company);
        }

        $manager->persist($company);

        $manager->flush();
    }
}
