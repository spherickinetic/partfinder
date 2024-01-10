<?php

namespace App\Entity;

use App\Repository\VendorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\MaxDepth;


#[ORM\Entity(repositoryClass: VendorRepository::class)]
#[UniqueEntity('vendorName', message: 'This vendor name is already in use',)]
class Vendor
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $vendorName = null;

    #[ORM\OneToMany(mappedBy: 'vendor', targetEntity: VendorPart::class)]
    #[MaxDepth(1)]
    private Collection $vendorParts;

    public function __construct()
    {
        $this->vendorParts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVendorName(): ?string
    {
        return $this->vendorName;
    }

    public function setVendorName(string $vendorName): static
    {
        $this->vendorName = $vendorName;

        return $this;
    }

    /**
     * @return Collection<int, VendorPart>
     */
    public function getVendorParts(): Collection
    {
        return $this->vendorParts;
    }

    public function addVendorPart(VendorPart $vendorPart): static
    {
        if (!$this->vendorParts->contains($vendorPart)) {
            $this->vendorParts->add($vendorPart);
            $vendorPart->setVendor($this);
        }

        return $this;
    }

    public function removeVendorPart(VendorPart $vendorPart): static
    {
        if ($this->vendorParts->removeElement($vendorPart)) {
            // set the owning side to null (unless already changed)
            if ($vendorPart->getVendor() === $this) {
                $vendorPart->setVendor(null);
            }
        }

        return $this;
    }
}
