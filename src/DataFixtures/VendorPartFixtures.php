<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use App\Entity\VendorPart;

class VendorPartFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $partNumbers = [
            "ACME" => [
                "Piston return springs" => "ACME-PRS",
                "Exhaust bearing" => "ACME-EB",
                "Transmission relay" => "ACME-TR",
                "Indicator fluid" => "ACME-IF",
                "Suspension hook" => "ACME-SH",
                "Radiator springs" => "ACME-RS",
                "Turbo encabulator" => "ACME-TE"
            ],

            "Cyberdyne" => [
                "Piston return springs" => "CD-PRS",
                "Suspension hook" => "CD-SH",
                "Radiator springs" => "CD-RS"
            ],

            "Soylent" => [
                "Indicator fluid" => "SOY-IF",
                "Exhaust bearing" => "SOY-EB",
                "Transmission relay" => "SOY-TR"
            ],

            "World Industries" => [
                "Turbo encabulator" => "WI-TE"
            ]
        ];

        foreach($partNumbers as $vendorName => $vendorPartNumbers)
        {
            foreach($vendorPartNumbers as $partNumber => $vendorPartNumber)
            {
                $vendorPart = new VendorPart();
                $vendorPart->setVendorPartNumber($vendorPartNumber);
                $vendorPart->setVendor($this->getReference(VendorFixtures::VENDOR_FIXTURE_REFERENCE . "_" . $vendorName));
                $vendorPart->setPart($this->getReference(PartFixtures::PART_FIXTURE_REFERENCE . "_" . $partNumber));

                $manager->persist($vendorPart);
            }
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            PartFixtures::class,
            VendorFixtures::class
        ];
    }
}
