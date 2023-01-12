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
            $rent->setVehicle($this->getReference('Kangoo_' . $i));
            $rent->setUser($this->getReference('randomUser_1'));
            $rent->setDestination('Paris');
            $rent->setRentedDate($faker->dateTimeBetween('-4 week', '-1 week'));
            $rent->setReturnDate($faker->dateTimeBetween('+1 week', '+4 week'));
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