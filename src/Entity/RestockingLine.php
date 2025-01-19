<?php

namespace App\Entity;

use App\Repository\RestockingLineRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RestockingLineRepository::class)]
class RestockingLine
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $quantity = null;

    #[ORM\ManyToOne(inversedBy: 'restockingLines')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Restocking $restocking = null;

    #[ORM\ManyToOne(inversedBy: 'restockingLines')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Article $article = null;

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

    public function getRestocking(): ?Restocking
    {
        return $this->restocking;
    }

    public function setRestocking(?Restocking $restocking): static
    {
        $this->restocking = $restocking;

        return $this;
    }

    public function getArticle(): ?Article
    {
        return $this->article;
    }

    public function setArticle(?Article $article): static
    {
        $this->article = $article;

        return $this;
    }

    public function getPrice(): float
    {
        return $this->article->getPrice() * $this->quantity;
    }
}
