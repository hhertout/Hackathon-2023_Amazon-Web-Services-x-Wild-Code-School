<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\DataFixtures\VehicleFixtures;
use App\Entity\Reservation;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ReservationFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        for ($i = 0; $i < VehicleFixtures::NB_VEHICLE_MODEL; $i++) {
            $rent = new Reservation();
            $rent->setVehicle($this->getReference('Kangoo_' . rand(0, $i)));
            $rent->setUser($this->getReference('randomReserver_1'));
            $rent->setDestination('Paris');
            $rent->setRentedDate($faker->dateTimeBetween('-' . rand(10, 20) . 'week', '-' . rand(10, 1) . 'week'));
            $rent->setReturnDate($faker->dateTimeBetween('+' . rand(1, 5) . 'week', '+' . rand(5, 10) . 'week'));
            $manager->persist($rent);

            $manager->flush($rent);
        }
        for ($i = 0; $i < VehicleFixtures::NB_VEHICLE_MODEL; $i++) {
            $rent = new Reservation();
            $rent->setVehicle($this->getReference('Partner_' . rand(0, $i)));
            $rent->setUser($this->getReference('randomReserver_1'));
            $rent->setDestination('Paris');
            $rent->setRentedDate($faker->dateTimeBetween('-' . rand(10, 20) . 'week', '-' . rand(10, 1) . 'week'));
            $rent->setReturnDate($faker->dateTimeBetween('+' . rand(1, 5) . 'week', '+' . rand(5, 10) . 'week'));
            $manager->persist($rent);

            $manager->flush($rent);
        }
        for ($i = 0; $i < VehicleFixtures::NB_VEHICLE_MODEL; $i++) {
            $rent = new Reservation();
            $rent->setVehicle($this->getReference('Clio_' . rand(0, $i)));
            $rent->setUser($this->getReference('randomReserver_1'));
            $rent->setDestination('Paris');
            $rent->setRentedDate($faker->dateTimeBetween('-' . rand(10, 20) . 'week', '-' . rand(10, 1) . 'week'));
            $rent->setReturnDate($faker->dateTimeBetween('+' . rand(1, 5) . 'week', '+' . rand(5, 10) . 'week'));
            $manager->persist($rent);

            $manager->flush($rent);
        }
        for ($i = 0; $i < VehicleFixtures::NB_VEHICLE_MODEL; $i++) {
            $rent = new Reservation();
            $rent->setVehicle($this->getReference('308_' . rand(0, $i)));
            $rent->setUser($this->getReference('randomReserver_1'));
            $rent->setDestination('Paris');
            $rent->setRentedDate($faker->dateTimeBetween('-' . rand(10, 20) . 'week', '-' . rand(10, 1) . 'week'));
            $rent->setReturnDate($faker->dateTimeBetween('+' . rand(1, 5) . 'week', '+' . rand(5, 10) . 'week'));
            $manager->persist($rent);

            $manager->flush($rent);
        }
    }
    public function getDependencies()
    {
        return [

            VehicleFixtures::class,

        ];
    }
}