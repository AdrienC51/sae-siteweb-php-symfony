<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    #[ORM\Column(length: 15)]
    private ?string $destPostCode = null;

    #[ORM\Column(length: 128)]
    private ?string $destCity = null;

    #[ORM\Column(length: 20)]
    private ?string $status = null;

    #[ORM\ManyToOne(inversedBy: 'orders')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Client $client = null;

    #[ORM\ManyToOne(inversedBy: 'orders')]
    private ?Delivery $delivery = null;

    /**
     * @var Collection<int, OrderLine>
     */
    #[ORM\OneToMany(targetEntity: OrderLine::class, mappedBy: 'relatedOrder', orphanRemoval: true)]
    private Collection $orderLines;

    public function __construct()
    {
        $this->orderLines = new ArrayCollection();
    } //Value = "Accepted", "In preparation", "Being delivered", "Delivered"

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

    public function getDelivery(): ?Delivery
    {
        return $this->delivery;
    }

    public function setDelivery(?Delivery $delivery): static
    {
        $this->delivery = $delivery;

        return $this;
    }

    /**
     * @return Collection<int, OrderLine>
     */
    public function getOrderLines(): Collection
    {
        return $this->orderLines;
    }

    public function addOrderLine(OrderLine $orderLine): static
    {
        if (!$this->orderLines->contains($orderLine)) {
            $this->orderLines->add($orderLine);
            $orderLine->setRelatedOrder($this);
        }

        return $this;
    }

    public function removeOrderLine(OrderLine $orderLine): static
    {
        if ($this->orderLines->removeElement($orderLine)) {
            // set the owning side to null (unless already changed)
            if ($orderLine->getRelatedOrder() === $this) {
                $orderLine->setRelatedOrder(null);
            }
        }

        return $this;
    }
}
