<?php

namespace App\DataFixtures;

use App\Entity\Vehicle;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class VehicleFixtures extends Fixture
{
    public const NB_VEHICLE_MODEL = 120;
    public const ENERGY = ['Gasoline', 'Electric', 'Diesel'];

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        //immatriculation AB-561-QT
        for ($i = 0; $i < self::NB_VEHICLE_MODEL; $i++) {
            $vehicle = new Vehicle();
            $vehicle->setBrand('Renault');
            $vehicle->setModel('Kangoo');
            $vehicle->setEnergy('Electric');
            $vehicle->setKilometers(rand(2300, 220000));
            $vehicle->setNbDoor(3);
            $vehicle->setIsKaput(false);
            $vehicle->setImmatriculation($faker->lexify('??') . '-' . $faker->randomNumber(3, true) . '-' . $faker->lexify('??'));
            $vehicle->setAutonomy(314);
            $vehicle->setType('Utility');
            $vehicle->setGearbox('Automatic');
            $vehicle->setIsSharedNow((bool)rand(0, 1));
            if ($vehicle->isIsSharedNow() === true) {
                $vehicle->setIsAvailable(false);
                $vehicle->setIsShared(false);
            } else {
                $vehicle->setIsAvailable(true);
                $vehicle->setIsShared(false);
            }
            $vehicle->setCompany($this->getReference('company_' . $faker->numberBetween(0, 6)));
            $this->addReference('Kangoo_' . $i, $vehicle);

            $manager->persist($vehicle);
        }

        for ($i = 0; $i < self::NB_VEHICLE_MODEL; $i++) {
            $vehicle = new Vehicle();
            $vehicle->setBrand('Peugeot');
            $vehicle->setModel('Partner');
            $vehicle->setEnergy('Gasoline');
            $vehicle->setNbDoor(3);
            $vehicle->setKilometers(rand(2300, 220000));
            $vehicle->setIsKaput(false);
            $vehicle->setImmatriculation($faker->lexify('??') . '-' . $faker->randomNumber(3, true) . '-' . $faker->lexify('??'));
            $vehicle->setCompany($this->getReference('company_' . $faker->numberBetween(0, 6)));
            $vehicle->setType('Utility');
            $vehicle->setGearbox('Manual');
            $vehicle->setIsSharedNow((bool)rand(0, 1));
            if ($vehicle->isIsSharedNow() === true) {
                $vehicle->setIsAvailable(false);
                $vehicle->setIsShared(false);
            } else {
                $vehicle->setIsAvailable(true);
                $vehicle->setIsShared(false);
            }
            $this->addReference('Partner_' . $i, $vehicle);

            $manager->persist($vehicle);
        }

        for ($i = 0; $i < self::NB_VEHICLE_MODEL; $i++) {
            $vehicle = new Vehicle();
            $vehicle->setBrand('Peugeot');
            $vehicle->setModel('308');
            $vehicle->setEnergy(self::ENERGY[array_rand(self::ENERGY)]);
            $vehicle->setNbDoor(5);
            $vehicle->setKilometers(rand(2300, 220000));
            $vehicle->setIsKaput(false);
            $vehicle->setImmatriculation($faker->lexify('??') . '-' . $faker->randomNumber(3, true) . '-' . $faker->lexify('??'));
            $vehicle->setCompany($this->getReference('company_' . $faker->numberBetween(0, 6)));
            $vehicle->setType('Urban');
            $vehicle->setGearbox('Automatic');
            $vehicle->setIsSharedNow((bool)rand(0, 1));
            if ($vehicle->isIsSharedNow() === true) {
                $vehicle->setIsAvailable(false);
                $vehicle->setIsShared(false);
            } else {
                $vehicle->setIsAvailable(true);
                $vehicle->setIsShared(true);
            }
            $this->addReference('308_' . $i, $vehicle);

            $manager->persist($vehicle);
        }

        for ($i = 0; $i < self::NB_VEHICLE_MODEL; $i++) {
            $vehicle = new Vehicle();
            $vehicle->setBrand('Renault');
            $vehicle->setModel('Clio III');
            $vehicle->setEnergy('Diesel');
            $vehicle->setNbDoor(5);
            $vehicle->setKilometers(rand(2300, 220000));
            $vehicle->setIsKaput(false);
            $vehicle->setImmatriculation($faker->lexify('??') . '-' . $faker->randomNumber(3, true) . '-' . $faker->lexify('??'));
            $vehicle->setCompany($this->getReference('company_' . $faker->numberBetween(0, 6)));
            $vehicle->setType('Urban');
            $vehicle->setGearbox('Manual');
            $vehicle->setIsSharedNow((bool)rand(0, 1));
            if ($vehicle->isIsSharedNow() === true) {
                $vehicle->setIsAvailable(false);
                $vehicle->setIsShared(false);
            } else {
                $vehicle->setIsAvailable(true);
                $vehicle->setIsShared(true);
            }
            $this->addReference('Clio_' . $i, $vehicle);

            $manager->persist($vehicle);
        }



        $vehicle = new Vehicle();
        $vehicle->setBrand('Renault');
        $vehicle->setModel('Kangoo');
        $vehicle->setEnergy('Electric');
        $vehicle->setNbDoor(3);
        $vehicle->setIsKaput(false);
        $vehicle->setKilometers(rand(2300, 220000));
        $vehicle->setImmatriculation($faker->lexify('??') . '-' . $faker->randomNumber(3, true) . '-' . $faker->lexify('??'));
        $vehicle->setAutonomy(314);
        $vehicle->setType('Utility');
        $vehicle->setGearbox('Automatic');
        $vehicle->setIsSharedNow((bool)rand(0, 1));
        if ($vehicle->isIsSharedNow() === true) {
            $vehicle->setIsAvailable(false);
            $vehicle->setIsShared(false);
        } else {
            $vehicle->setIsAvailable(true);
            $vehicle->setIsShared(true);
        }
        $vehicle->setIsKaput(true);
        $vehicle->setCompany($this->getReference('company_' . '1'));
        $this->addReference('Kangoo_' . 122, $vehicle);

        $manager->persist($vehicle);

        $vehicle = new Vehicle();
        $vehicle->setBrand('Renault');
        $vehicle->setModel('Kangoo');
        $vehicle->setEnergy('Electric');
        $vehicle->setNbDoor(3);
        $vehicle->setIsKaput(false);
        $vehicle->setImmatriculation($faker->lexify('??') . '-' . $faker->randomNumber(3, true) . '-' . $faker->lexify('??'));
        $vehicle->setAutonomy(314);
        $vehicle->setKilometers(rand(2300, 220000));
        $vehicle->setType('Utility');
        $vehicle->setGearbox('Automatic');
        $vehicle->setIsSharedNow((bool)rand(0, 1));
        if ($vehicle->isIsSharedNow() === true) {
            $vehicle->setIsAvailable(false);
            $vehicle->setIsShared(false);
        } else {
            $vehicle->setIsAvailable(true);
            $vehicle->setIsShared(true);
        }
        $vehicle->setCompany($this->getReference('company_' . '8'));
        $this->addReference('Clio_' . 122, $vehicle);

        $manager->persist($vehicle);

        $vehicle = new Vehicle();
        $vehicle->setBrand('Renault');
        $vehicle->setModel('Kangoo');
        $vehicle->setEnergy('Electric');
        $vehicle->setNbDoor(3);
        $vehicle->setKilometers(rand(2300, 220000));
        $vehicle->setIsKaput(false);
        $vehicle->setImmatriculation($faker->lexify('??') . '-' . $faker->randomNumber(3, true) . '-' . $faker->lexify('??'));
        $vehicle->setAutonomy(314);
        $vehicle->setType('Utility');
        $vehicle->setGearbox('Automatic');
        $vehicle->setIsSharedNow((bool)rand(0, 1));
        if ($vehicle->isIsSharedNow() === true) {
            $vehicle->setIsAvailable(false);
            $vehicle->setIsShared(false);
        } else {
            $vehicle->setIsAvailable(true);
            $vehicle->setIsShared(true);
        }
        $vehicle->setCompany($this->getReference('company_' . '9'));
        $this->addReference('Kangoo_' . 123, $vehicle);

        $manager->persist($vehicle);

        $vehicle = new Vehicle();
        $vehicle->setBrand('Renault');
        $vehicle->setModel('Kangoo');
        $vehicle->setEnergy('Electric');
        $vehicle->setNbDoor(3);
        $vehicle->setIsShared(true);
        $vehicle->setKilometers(rand(2300, 220000));
        $vehicle->setIsKaput(false);
        $vehicle->setImmatriculation($faker->lexify('??') . '-' . $faker->randomNumber(3, true) . '-' . $faker->lexify('??'));
        $vehicle->setAutonomy(314);
        $vehicle->setType('Utility');
        $vehicle->setGearbox('Automatic');
        $vehicle->setIsAvailable(true);
        $vehicle->setCompany($this->getReference('company_' . '9'));
        $vehicle->setIsSharedNow(false);
        $this->addReference('Clio_' . 123, $vehicle);

        $manager->persist($vehicle);

        //vehicule sharable d'amazon pour la demo
        $vehicle = new Vehicle();
        $vehicle->setBrand('Honda');
        $vehicle->setModel('Civic');
        $vehicle->setEnergy('Gazoline');
        $vehicle->setNbDoor(3);
        $vehicle->setIsShared(true);
        $vehicle->setKilometers(rand(2300, 220000));
        $vehicle->setIsKaput(false);
        $vehicle->setImmatriculation($faker->lexify('??') . '-' . $faker->randomNumber(3, true) . '-' . $faker->lexify('??'));
        $vehicle->setAutonomy(314);
        $vehicle->setType('Sedan');
        $vehicle->setGearbox('Automatic');
        $vehicle->setIsAvailable(true);
        $vehicle->setCompany($this->getReference('company_2'));
        $vehicle->setIsSharedNow(false);
        $this->addReference('Kangoo_' . 124, $vehicle);

        $manager->persist($vehicle);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [

            CompanyFixtures::class,

        ];
    }
}
