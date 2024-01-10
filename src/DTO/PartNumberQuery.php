<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class PartNumberQuery
{
    #[Assert\NotBlank]
    private ?string $vendorPartNumber = null;

    private ?string $partNumber = null;

    public function getVendorPartNumber(): ?string
    {
        return $this->vendorPartNumber;
    }

    public function setVendorPartNumber(?string $vendorPartNumber): self
    {
        $this->vendorPartNumber = $vendorPartNumber;
        return $this;
    }

    public function getPartNumber(): ?string
    {
        return $this->partNumber;
    }

    public function setPartNumber(?string $partNumber): self
    {
        $this->partNumber = $partNumber;
        return $this;
    }
}