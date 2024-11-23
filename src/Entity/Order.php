<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $orderDate = null;

    #[ORM\Column(length: 200)]
    private ?string $destAddress = null;

    #[ORM\Column(length: 5)]
    private ?string $destPostCode = null;

    #[ORM\Column(length: 128)]
    private ?string $destCity = null;

    #[ORM\Column(length: 20)]
    private ?string $status = null;

    #[ORM\ManyToOne(inversedBy: 'orders')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Client $client = null; //Value = "Accepted", "In preparation", "Being delivered", "Delivered"

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrderDate(): ?\DateTimeInterface
    {
        return $this->orderDate;
    }

    public function setOrderDate(?\DateTimeInterface $orderDate): static
    {
        $this->orderDate = $orderDate;

        return $this;
    }

    public function getDestAddress(): ?string
    {
        return $this->destAddress;
    }

    public function setDestAddress(string $destAddress): static
    {
        $this->destAddress = $destAddress;

        return $this;
    }

    public function getDestPostCode(): ?string
    {
        return $this->destPostCode;
    }

    public function setDestPostCode(string $destPostCode): static
    {
        $this->destPostCode = $destPostCode;

        return $this;
    }

    public function getDestCity(): ?string
    {
        return $this->destCity;
    }

    public function setDestCity(string $destCity): static
    {
        $this->destCity = $destCity;

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

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): static
    {
        $this->client = $client;

        return $this;
    }
}
