<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use App\Entity\Part;

class PartFixtures extends Fixture
{
    public const PART_FIXTURE_REFERENCE = "part";

    public function load(ObjectManager $manager): void
    {
        $partNumbers = [
            "Piston return springs",
            "Exhaust bearing",
            "Transmission relay",
            "Indicator fluid",
            "Suspension hook",
            "Radiator springs",
            "Turbo encabulator"
        ];

        foreach($partNumbers as $partNumber)
        {
            $part = new Part();
            $part->setPartNumber($partNumber);

            $manager->persist($part);
            $manager->flush();

            $this->addReference(self::PART_FIXTURE_REFERENCE . "_" . $partNumber, $part);
        }
    }
}
