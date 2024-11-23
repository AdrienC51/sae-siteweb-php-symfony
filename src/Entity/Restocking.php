<?php

namespace App\Entity;

use App\Repository\RestockingRepository;
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

    #[ORM\ManyToOne(inversedBy: 'Restockings')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Admin $admin = null; //Value = "Pending", "Received"

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
}
