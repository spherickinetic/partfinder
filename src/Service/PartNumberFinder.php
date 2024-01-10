<?php

namespace App\Service;

use App\Repository\VendorPartRepository;

class PartNumberFinder
{
    public function __construct(VendorPartRepository $vendorPartRepo)
    {
        $this->vendorPartRepo = $vendorPartRepo;
    }

    public function find($query)
    {
        $vendorPartNumber = $query->getVendorPartNumber();
        $result = $this->vendorPartRepo->findOneBy(['vendorPartNumber' => $vendorPartNumber]);
        if($result)
        {
            $query->setPartNumber($result->getPart()->getPartNumber());
        }

        return $query;
    }
}