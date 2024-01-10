<?php

namespace App\Factory;

use App\Entity\Part;

class PartFactory
{
    public static function create(PartDTO $partDTO): Part
    {
        $part = new Part();

        $part->setPartNumber = $partDTO->getPartNumber;
         
        return $part;
    }
}