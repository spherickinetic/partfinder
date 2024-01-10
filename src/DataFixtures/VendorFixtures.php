<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use App\Entity\Vendor;

class VendorFixtures extends Fixture
{
    public const VENDOR_FIXTURE_REFERENCE = "vendor";

    public function load(ObjectManager $manager): void
    {
        $vendorNames = [
            "ACME",
            "Cyberdyne",
            "Soylent",
            "World Industries"
        ];

        foreach($vendorNames as $vendorName)
        {
            $vendor = new Vendor();
            $vendor->setVendorName($vendorName);

            $manager->persist($vendor);
            $manager->flush();

            $this->addReference(self::VENDOR_FIXTURE_REFERENCE . "_" . $vendorName, $vendor);
        }

    }
}
