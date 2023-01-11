<?php

namespace App\DataFixtures;

use App\Entity\Company;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use App\Service\HereMapAPI;

class CompanyFixtures extends Fixture
{
    public const NB_COMPANY = 6;

    public function __construct(private HereMapAPI $hereMapAPI)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < self::NB_COMPANY; $i++) {
            $company = new Company();
            $company->setName($faker->words(3, true));
            $company->setSIRET($faker->numberBetween(1111111111111, 9999999999999));
            $this->addReference('company_' . $i, $company);
            $company->setAddress('3 rue de l\'adresse, 75000 Paris');
            $company->setLatitude($this->hereMapAPI->geolocateViaAddress($company->getAddress())['lat']);
            $company->setLongitude($this->hereMapAPI->geolocateViaAddress($company->getAddress())['lng']);

            $manager->persist($company);
        }
        //Company 7 : Région Centre
        $company = new Company();
        $company->setName('Conseil Régional du Centre-Val de Loire');
        $company->setSIRET($faker->numberBetween(1111111111111, 9999999999999));
        $this->addReference('company_' . 8, $company);
        $company->setAddress('9 Rue Saint-Pierre Lentin, 45000 Orléans');
        $company->setLatitude($this->hereMapAPI->geolocateViaAddress($company->getAddress())['lat']);
        $company->setLongitude($this->hereMapAPI->geolocateViaAddress($company->getAddress())['lng']);

        $manager->persist($company);

        //Company 8 : Glaces moustache proche de la Région Centre
        $company = new Company();
        $company->setName('Glaces Moustache');
        $company->setSIRET($faker->numberBetween(1111111111111, 9999999999999));
        $this->addReference('company_' . 9, $company);
        $company->setAddress('3 Rue Jeanne d\'Arc, 45000 Orléans');
        $company->setLatitude($this->hereMapAPI->geolocateViaAddress($company->getAddress())['lat']);
        $company->setLongitude($this->hereMapAPI->geolocateViaAddress($company->getAddress())['lng']);

        $manager->persist($company);

        //Company 9 : 
        $company = new Company();
        $company->setName('Leclerc Vendome');
        $company->setSIRET($faker->numberBetween(1111111111111, 9999999999999));
        $this->addReference('company_' . 10, $company);
        $company->setAddress('76 Rue de Courtiras, 41100 Vendôme');
        $company->setLatitude($this->hereMapAPI->geolocateViaAddress($company->getAddress())['lat']);
        $company->setLongitude($this->hereMapAPI->geolocateViaAddress($company->getAddress())['lng']);

        $manager->persist($company);

        $manager->flush();
    }
}
