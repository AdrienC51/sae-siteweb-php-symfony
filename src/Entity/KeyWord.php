<?php

namespace App\Entity;

use App\Repository\KeyWordRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: KeyWordRepository::class)]
class KeyWord
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 128)]
    private ?string $word = null;

    /**
     * @var Collection<int, ArticleType>
     */
    #[ORM\ManyToMany(targetEntity: ArticleType::class, mappedBy: 'keyWords')]
    private Collection $articleTypes;

    public function __construct()
    {
        $this->articleTypes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWord(): ?string
    {
        return $this->word;
    }

    public function setWord(string $word): static
    {
        $this->word = $word;

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
            $articleType->addKeyWord($this);
        }

        return $this;
    }

    public function removeArticleType(ArticleType $articleType): static
    {
        if ($this->articleTypes->removeElement($articleType)) {
            $articleType->removeKeyWord($this);
        }

        return $this;
    }
}
