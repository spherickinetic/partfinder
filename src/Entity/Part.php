<?php

namespace App\Entity;

use App\Repository\PartRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\MaxDepth;

#[ORM\Entity(repositoryClass: PartRepository::class)]
#[UniqueEntity('partNumber', message: 'This part number is already in use',)]
class Part
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $partNumber = null;

    #[ORM\OneToMany(mappedBy: 'part', targetEntity: VendorPart::class)]
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

    public function getPartNumber(): ?string
    {
        return $this->partNumber;
    }

    public function setPartNumber(string $partNumber): static
    {
        $this->partNumber = $partNumber;

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
            $vendorPart->setPart($this);
        }

        return $this;
    }

    public function removeVendorPart(VendorPart $vendorPart): static
    {
        if ($this->vendorParts->removeElement($vendorPart)) {
            // set the owning side to null (unless already changed)
            if ($vendorPart->getPart() === $this) {
                $vendorPart->setPart(null);
            }
        }

        return $this;
    }
}
