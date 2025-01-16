<?php

namespace App\Entity;

use App\Repository\RestockingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RestockingRepository::class)]
class Restocking
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $restockDate = null;

    #[ORM\Column(length: 20)]
    private ?string $status = null;


    /**
     * @var Collection<int, RestockingLine>
     */
    #[ORM\OneToMany(targetEntity: RestockingLine::class, mappedBy: 'restocking', orphanRemoval: true)]
    private Collection $restockingLines;

    public function __construct()
    {
        $this->restockingLines = new ArrayCollection();
    } // Value = "Pending", "Received"

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRestockDate(): ?\DateTimeInterface
    {
        return $this->restockDate;
    }

    public function setRestockDate(?\DateTimeInterface $restockDate): static
    {
        $this->restockDate = $restockDate;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getAdmin(): ?Admin
    {
        return $this->admin;
    }

    public function setAdmin(?Admin $admin): static
    {
        $this->admin = $admin;

        return $this;
    }

    /**
     * @return Collection<int, RestockingLine>
     */
    public function getRestockingLines(): Collection
    {
        return $this->restockingLines;
    }

    public function addRestockingLine(RestockingLine $restockingLine): static
    {
        if (!$this->restockingLines->contains($restockingLine)) {
            $this->restockingLines->add($restockingLine);
            $restockingLine->setRestocking($this);
        }

        return $this;
    }

    public function removeRestockingLine(RestockingLine $restockingLine): static
    {
        if ($this->restockingLines->removeElement($restockingLine)) {
            // set the owning side to null (unless already changed)
            if ($restockingLine->getRestocking() === $this) {
                $restockingLine->setRestocking(null);
            }
        }

        return $this;
    }
    public function getPrice()
    {
        $total = 0.0;
        foreach ($this->restockingLines as $restockLine) {
            $total += $restockLine->getPrice();
        }
        return $total;
    }
}
