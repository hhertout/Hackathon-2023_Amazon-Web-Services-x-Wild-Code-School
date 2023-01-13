<?php

namespace App\DataFixtures;

use App\Entity\Company;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use App\Service\HereMapAPI;

class CompanyFixtures extends Fixture
{
    public const COMPANY = [
        'Facebook' => 'https://upload.wikimedia.org/wikipedia/en/thumb/0/04/Facebook_f_logo_%282021%29.svg/2048px-Facebook_f_logo_%282021%29.svg.png',
        'Google' => 'https://1.bp.blogspot.com/-XemA_lVnYUM/XD0AmWCI0pI/AAAAAAAAG3g/hoXWSjqiEeIqdCASF-v7wagtpOzM5tWTwCK4BGAYYCw/s1600/logo%2Bgoogle.png',
        'Amazon' => 'https://cdn4.iconfinder.com/data/icons/social-media-2146/512/31_social-512.png',
        'Uber' => 'https://www.logo.wine/a/logo/Uber/Uber-White-Dark-Background-Logo.wine.svg',
        'Total' => 'https://seeklogo.com/images/T/Total_Oil_2007-logo-2B2DA3BF11-seeklogo.com.png',
        'deliveroo' => 'https://media.graphiline.com/graphiline/23792/logo-sign-deliveroo-2.png',
        'Région Centre' => 'https://upload.wikimedia.org/wikipedia/fr/thumb/d/da/Logo_Centre_Val_Loire_2015.svg/1200px-Logo_Centre_Val_Loire_2015.svg.png'
    ];


    public function __construct(private HereMapAPI $hereMapAPI)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        $i = 0;
        foreach(self::COMPANY as $name => $logo) {
            $company = new Company();
            $company->setName($name);
            $company->setSIRET($faker->numberBetween(1111111111111, 9999999999999));
            $this->addReference('company_' . $i, $company);
            $company->setAddress('30 Rue du Canal, 44210 Pornic');
            $company->setLatitude($this->hereMapAPI->geolocateViaAddress($company->getAddress())['lat']);
            $company->setLongitude($this->hereMapAPI->geolocateViaAddress($company->getAddress())['lng']);
            $company->setLogo($logo);

            $manager->persist($company);
            $i++;
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
