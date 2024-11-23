<?php

namespace App\Entity;

use App\Repository\StockEvolutionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StockEvolutionRepository::class)]
class StockEvolution
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $quantity = null;

    #[ORM\Column(length: 3)]
    private ?string $type = null; //Value = "IN" or "OUT"

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $evolutionDate = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getEvolutionDate(): ?\DateTimeInterface
    {
        return $this->evolutionDate;
    }

    public function setEvolutionDate(\DateTimeInterface $evolutionDate): static
    {
        $this->evolutionDate = $evolutionDate;

        return $this;
    }
}
