<?php

namespace App\DataFixtures;

use App\Entity\Vehicle;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class VehicleFixtures extends Fixture
{
    public const NB_VEHICLE_MODEL = 100;
    public const ENERGY = ['Gazoline', 'Electric', 'Diesel'];

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < self::NB_VEHICLE_MODEL; $i++) {
            $vehicle = new Vehicle();
            $vehicle->setBrand('Renault');
            $vehicle->setModel('Kangoo');
            $vehicle->setEnergy('Electric');
            $vehicle->setKilometers(rand(2300, 220000));
            $vehicle->setNbDoor(3);
            $vehicle->setIsShared(false);
            $vehicle->setIsKaput(false);
            $vehicle->setImmatriculation($faker->lexify('??') . '-' . $faker->randomNumber(3, true) . '-' . $faker->lexify('??'));
            $vehicle->setAutonomy(314);
            $vehicle->setType('Utility');
            $vehicle->setGearbox('Automatic');
            $vehicle->setIsSharedNow((bool)rand(0, 1));
            $vehicle->setIsAvailable((bool)rand(0, 1));
            $vehicle->setCompany($this->getReference('company_' . $faker->numberBetween(0, 5)));
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
            $vehicle->setIsShared(false);
            $vehicle->setIsKaput(false);
            $vehicle->setImmatriculation($faker->lexify('??') . '-' . $faker->randomNumber(3, true) . '-' . $faker->lexify('??'));
            $vehicle->setCompany($this->getReference('company_' . $faker->numberBetween(0, 5)));
            $vehicle->setType('Utility');
            $vehicle->setGearbox('Manual');
            $vehicle->setIsAvailable((bool)rand(0, 1));
            $vehicle->setIsSharedNow((bool)rand(0, 1));
            $this->addReference('Partner_' . $i, $vehicle);

            $manager->persist($vehicle);
        }

        for ($i = 0; $i < self::NB_VEHICLE_MODEL; $i++) {
            $vehicle = new Vehicle();
            $vehicle->setBrand('Peugeot');
            $vehicle->setModel('308');
            $vehicle->setEnergy(self::ENERGY[array_rand(self::ENERGY)]);
            $vehicle->setNbDoor(5);
            $vehicle->setIsShared(false);
            $vehicle->setKilometers(rand(2300, 220000));
            $vehicle->setIsKaput(false);
            $vehicle->setImmatriculation($faker->lexify('??') . '-' . $faker->randomNumber(3, true) . '-' . $faker->lexify('??'));
            $vehicle->setCompany($this->getReference('company_' . $faker->numberBetween(0, 5)));
            $vehicle->setType('Urban');
            $vehicle->setGearbox('Automatic');
            $vehicle->setIsAvailable((bool)rand(0, 1));
            $vehicle->setIsSharedNow((bool)rand(0, 1));
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
            $vehicle->setIsShared(false);
            $vehicle->setIsKaput(false);
            $vehicle->setImmatriculation($faker->lexify('??') . '-' . $faker->randomNumber(3, true) . '-' . $faker->lexify('??'));
            $vehicle->setCompany($this->getReference('company_' . $faker->numberBetween(0, 5)));
            $vehicle->setType('Urban');
            $vehicle->setGearbox('Manual');
            $vehicle->setIsShared((bool)rand(0, 1));
            $vehicle->setIsAvailable((bool)rand(0, 1));
            $vehicle->setIsSharedNow((bool)rand(0, 1));
            $this->addReference('Clio_' . $i, $vehicle);

            $manager->persist($vehicle);
        }



        $vehicle = new Vehicle();
        $vehicle->setBrand('Renault');
        $vehicle->setModel('Kangoo');
        $vehicle->setEnergy('Electric');
        $vehicle->setNbDoor(3);
        $vehicle->setIsShared(false);
        $vehicle->setIsKaput(false);
        $vehicle->setKilometers(rand(2300, 220000));
        $vehicle->setImmatriculation($faker->lexify('??') . '-' . $faker->randomNumber(3, true) . '-' . $faker->lexify('??'));
        $vehicle->setAutonomy(314);
        $vehicle->setType('Utility');
        $vehicle->setGearbox('Automatic');
        $vehicle->setIsAvailable((bool)rand(0, 1));
        $vehicle->setIsKaput(true);
        $vehicle->setCompany($this->getReference('company_' . '1'));
        $vehicle->setIsSharedNow((bool)rand(0, 1));
        $this->addReference('Kangoo_' . 101, $vehicle);

        $manager->persist($vehicle);

        $vehicle = new Vehicle();
        $vehicle->setBrand('Renault');
        $vehicle->setModel('Kangoo');
        $vehicle->setEnergy('Electric');
        $vehicle->setNbDoor(3);
        $vehicle->setIsShared(false);
        $vehicle->setIsKaput(false);
        $vehicle->setImmatriculation($faker->lexify('??') . '-' . $faker->randomNumber(3, true) . '-' . $faker->lexify('??'));
        $vehicle->setAutonomy(314);
        $vehicle->setKilometers(rand(2300, 220000));
        $vehicle->setType('Utility');
        $vehicle->setGearbox('Automatic');
        $vehicle->setIsAvailable((bool)rand(0, 1));
        $vehicle->setCompany($this->getReference('company_' . '8'));
        $vehicle->setIsSharedNow((bool)rand(0, 1));
        $this->addReference('Clio_' . 101, $vehicle);

        $manager->persist($vehicle);

        $vehicle = new Vehicle();
        $vehicle->setBrand('Renault');
        $vehicle->setModel('Kangoo');
        $vehicle->setEnergy('Electric');
        $vehicle->setNbDoor(3);
        $vehicle->setIsShared(false);
        $vehicle->setKilometers(rand(2300, 220000));
        $vehicle->setIsKaput(false);
        $vehicle->setImmatriculation($faker->lexify('??') . '-' . $faker->randomNumber(3, true) . '-' . $faker->lexify('??'));
        $vehicle->setAutonomy(314);
        $vehicle->setType('Utility');
        $vehicle->setGearbox('Automatic');
        $vehicle->setIsAvailable((bool)rand(0, 1));
        $vehicle->setCompany($this->getReference('company_' . '9'));
        $vehicle->setIsSharedNow((bool)rand(0, 1));
        $this->addReference('Kangoo_' . 102, $vehicle);

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
        $vehicle->setIsAvailable((bool)rand(0, 1));
        $vehicle->setCompany($this->getReference('company_' . '9'));
        $vehicle->setIsSharedNow((bool)rand(0, 1));
        $this->addReference('Clio_' . 102, $vehicle);

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
