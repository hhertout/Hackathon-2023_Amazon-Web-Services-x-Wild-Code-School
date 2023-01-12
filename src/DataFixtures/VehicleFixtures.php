<?php

namespace App\DataFixtures;

use App\Entity\Vehicle;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class VehicleFixtures extends Fixture
{
    public const NB_VEHICLE_MODEL = 100;
    public const ENERGY = ['Gazoline', 'Electic', 'Diesel'];

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < self::NB_VEHICLE_MODEL; $i++) {
            $vehicle = new Vehicle();
            $vehicle->setBrand('Renault');
            $vehicle->setModel('Kangoo');
            $vehicle->setEnergy('Electric');
            $vehicle->setNbSeat(3);
            $vehicle->setIsShared(false);
            $vehicle->setIsKaput(false);
            $vehicle->setImmatriculation($faker->lexify('??') . '-' . $faker->randomNumber(3, true) . '-' . $faker->lexify('??'));
            $vehicle->setAutonomy(314);
            $vehicle->setType('Utility');
            $vehicle->setGearbox('Automatic');
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
            $vehicle->setNbSeat(3);
            $vehicle->setIsShared(false);
            $vehicle->setIsKaput(false);
            $vehicle->setImmatriculation($faker->lexify('??') . '-' . $faker->randomNumber(3, true) . '-' . $faker->lexify('??'));
            $vehicle->setCompany($this->getReference('company_' . $faker->numberBetween(0, 5)));
            $vehicle->setType('Utility');
            $vehicle->setGearbox('Manual');
            $vehicle->setIsAvailable((bool)rand(0, 1));
            $this->addReference('Partner_' . $i, $vehicle);

            $manager->persist($vehicle);
        }

        for ($i = 0; $i < self::NB_VEHICLE_MODEL; $i++) {
            $vehicle = new Vehicle();
            $vehicle->setBrand('Peugeot');
            $vehicle->setModel('308');
            $vehicle->setEnergy(self::ENERGY[array_rand(self::ENERGY)]);
            $vehicle->setNbSeat(5);
            $vehicle->setIsShared(false);
            $vehicle->setIsKaput(false);
            $vehicle->setImmatriculation($faker->lexify('??') . '-' . $faker->randomNumber(3, true) . '-' . $faker->lexify('??'));
            $vehicle->setCompany($this->getReference('company_' . $faker->numberBetween(0, 5)));
            $vehicle->setType('Urban');
            $vehicle->setGearbox('Automatic');
            $vehicle->setIsAvailable((bool)rand(0, 1));
            $this->addReference('308_' . $i, $vehicle);

            $manager->persist($vehicle);
        }

        for ($i = 0; $i < self::NB_VEHICLE_MODEL; $i++) {
            $vehicle = new Vehicle();
            $vehicle->setBrand('Renault');
            $vehicle->setModel('Clio III');
            $vehicle->setEnergy('Diesel');
            $vehicle->setNbSeat(5);
            $vehicle->setIsShared(false);
            $vehicle->setIsKaput(false);
            $vehicle->setImmatriculation($faker->lexify('??') . '-' . $faker->randomNumber(3, true) . '-' . $faker->lexify('??'));
            $vehicle->setCompany($this->getReference('company_' . $faker->numberBetween(0, 5)));
            $vehicle->setType('Urban');
            $vehicle->setGearbox('Manual');
            $vehicle->setIsAvailable((bool)rand(0, 1));
            $this->addReference('Clio_' . $i, $vehicle);

            $manager->persist($vehicle);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [

            CompanyFixtures::class,

        ];
    }
}
