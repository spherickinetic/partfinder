<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class PartDTO
{
    #[Assert\NotBlank]
    private ?string $partNumber = null;

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