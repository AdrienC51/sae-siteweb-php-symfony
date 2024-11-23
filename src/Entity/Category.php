<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 128)]
    private ?string $name = null;

    /**
     * @var Collection<int, ArticleType>
     */
    #[ORM\ManyToMany(targetEntity: ArticleType::class, mappedBy: 'categories')]
    private Collection $articleTypes;

    public function __construct()
    {
        $this->articleTypes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, ArticleType>
     */
    public function getArticleTypes(): Collection
    {
        return $this->articleTypes;
    }

    public function addArticleType(ArticleType $articleType): static
    {
        if (!$this->articleTypes->contains($articleType)) {
            $this->articleTypes->add($articleType);
            $articleType->addCategory($this);
        }

        return $this;
    }

    public function removeArticleType(ArticleType $articleType): static
    {
        if ($this->articleTypes->removeElement($articleType)) {
            $articleType->removeCategory($this);
        }

        return $this;
    }
}
