<?php

namespace App\Entity;

use App\Repository\VendorPartRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\MaxDepth;

#[ORM\Entity(repositoryClass: VendorPartRepository::class)]
class VendorPart
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $vendorPartNumber = null;

    #[ORM\ManyToOne(inversedBy: 'vendorParts')]
    #[ORM\JoinColumn(nullable: false)]
    #[MaxDepth(1)]
    private ?Vendor $vendor = null;

    #[ORM\ManyToOne(inversedBy: 'vendorParts')]
    #[ORM\JoinColumn(nullable: false)]
    #[MaxDepth(1)]
    private ?Part $part = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVendorPartNumber(): ?string
    {
        return $this->vendorPartNumber;
    }

    public function setVendorPartNumber(string $vendorPartNumber): static
    {
        $this->vendorPartNumber = $vendorPartNumber;

        return $this;
    }

    public function getVendor(): ?Vendor
    {
        return $this->vendor;
    }

    public function setVendor(?Vendor $vendor): static
    {
        $this->vendor = $vendor;

        return $this;
    }

    public function getPart(): ?Part
    {
        return $this->part;
    }

    public function setPart(?Part $part): static
    {
        $this->part = $part;

        return $this;
    }
}
