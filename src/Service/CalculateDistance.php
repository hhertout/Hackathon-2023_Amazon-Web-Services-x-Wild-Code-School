<?php

namespace App\Service;

use App\Entity\Company;

class CalculateDistance
{
    public const EARTH_RADIUS = 3958.756;

    public function checkDistances(Company $userCompany, array $companies): array
    {
        foreach ($companies as $externalCompany) {

            $long1 = deg2rad($userCompany->getLongitude());
            $long2 = deg2rad($externalCompany->getLongitude());
            $lat1 = deg2rad($userCompany->getLatitude());
            $lat2 = deg2rad($externalCompany->getLatitude());

            $dlong = $long2 - $long1;
            $dlati = $lat2 - $lat1;

            $val = pow(sin($dlati / 2), 2) + cos($lat1) * cos($lat2) * pow(sin($dlong / 2), 2);

            $res = 2 * asin(sqrt($val));

            $radius = self::EARTH_RADIUS;

            $distance = ($res * $radius) * 1.609;
            $distances[] = $distance;
            if ($distance <= 20) {
                $nearCompanies[] = $externalCompany;
            }
        }
        return $nearCompanies;
    }
}
