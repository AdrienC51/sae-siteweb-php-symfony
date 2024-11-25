<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
class Article
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 128)]
    private ?string $name = null;

    #[ORM\Column]
    private ?float $price = null;

    #[ORM\Column(length: 300, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: Types::BLOB, nullable: true)]
    private $picture;

    /**
     * @var Collection<int, OrderLine>
     */
    #[ORM\OneToMany(targetEntity: OrderLine::class, mappedBy: 'article')]
    private Collection $orderLines;

    /**
     * @var Collection<int, CartLine>
     */
    #[ORM\OneToMany(targetEntity: CartLine::class, mappedBy: 'article', orphanRemoval: true)]
    private Collection $cartLines;

    /**
     * @var Collection<int, RestockingLine>
     */
    #[ORM\OneToMany(targetEntity: RestockingLine::class, mappedBy: 'article')]
    private Collection $restockingLines;

    /**
     * @var Collection<int, StockEvolution>
     */
    #[ORM\OneToMany(targetEntity: StockEvolution::class, mappedBy: 'article', orphanRemoval: true)]
    private Collection $evolutions;

    /**
     * @var Collection<int, Article>
     */
    #[ORM\OneToMany(targetEntity: Unit::class, mappedBy: 'article', orphanRemoval: true)]
    private Collection $articlesDetail;

    /**
     * @var Collection<int, KeyWord>
     */
    #[ORM\ManyToMany(targetEntity: KeyWord::class, inversedBy: 'articles')]
    private Collection $keyWords;

    /**
     * @var Collection<int, Category>
     */
    #[ORM\ManyToMany(targetEntity: Category::class, inversedBy: 'articles')]
    private Collection $categories;

    public function __construct()
    {
        $this->orderLines = new ArrayCollection();
        $this->cartLines = new ArrayCollection();
        $this->restockingLines = new ArrayCollection();
        $this->evolutions = new ArrayCollection();
        $this->articlesDetail = new ArrayCollection();
        $this->keyWords = new ArrayCollection();
        $this->categories = new ArrayCollection();
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

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getPicture()
    {
        return $this->picture;
    }

    public function setPicture($picture): static
    {
        $this->picture = $picture;

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
            $orderLine->setArticleType($this);
        }

        return $this;
    }

    public function removeOrderLine(OrderLine $orderLine): static
    {
        if ($this->orderLines->removeElement($orderLine)) {
            // set the owning side to null (unless already changed)
            if ($orderLine->getArticleType() === $this) {
                $orderLine->setArticleType(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, CartLine>
     */
    public function getCartLines(): Collection
    {
        return $this->cartLines;
    }

    public function addCartLine(CartLine $cartLine): static
    {
        if (!$this->cartLines->contains($cartLine)) {
            $this->cartLines->add($cartLine);
            $cartLine->setArticleType($this);
        }

        return $this;
    }

    public function removeCartLine(CartLine $cartLine): static
    {
        if ($this->cartLines->removeElement($cartLine)) {
            // set the owning side to null (unless already changed)
            if ($cartLine->getArticle() === $this) {
                $cartLine->setArticle(null);
            }
        }

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
            $restockingLine->setArticle($this);
        }

        return $this;
    }

    public function removeRestockingLine(RestockingLine $restockingLine): static
    {
        if ($this->restockingLines->removeElement($restockingLine)) {
            // set the owning side to null (unless already changed)
            if ($restockingLine->getArticle() === $this) {
                $restockingLine->setArticle(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, StockEvolution>
     */
    public function getEvolutions(): Collection
    {
        return $this->evolutions;
    }

    public function addEvolution(StockEvolution $evolution): static
    {
        if (!$this->evolutions->contains($evolution)) {
            $this->evolutions->add($evolution);
            $evolution->setArticle($this);
        }

        return $this;
    }

    public function removeEvolution(StockEvolution $evolution): static
    {
        if ($this->evolutions->removeElement($evolution)) {
            // set the owning side to null (unless already changed)
            if ($evolution->getArticle() === $this) {
                $evolution->setArticle(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Article>
     */
    public function getArticlesDetail(): Collection
    {
        return $this->articlesDetail;
    }

    public function addArticlesDetail(Article $articlesDetail): static
    {
        if (!$this->articlesDetail->contains($articlesDetail)) {
            $this->articlesDetail->add($articlesDetail);
            $articlesDetail->setArticle($this);
        }

        return $this;
    }

    public function removeArticlesDetail(Article $articlesDetail): static
    {
        if ($this->articlesDetail->removeElement($articlesDetail)) {
            // set the owning side to null (unless already changed)
            if ($articlesDetail->getArticle() === $this) {
                $articlesDetail->setArticle(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, KeyWord>
     */
    public function getKeyWords(): Collection
    {
        return $this->keyWords;
    }

    public function addKeyWord(KeyWord $keyWord): static
    {
        if (!$this->keyWords->contains($keyWord)) {
            $this->keyWords->add($keyWord);
        }

        return $this;
    }

    public function removeKeyWord(KeyWord $keyWord): static
    {
        $this->keyWords->removeElement($keyWord);

        return $this;
    }

    /**
     * @return Collection<int, Category>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): static
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
        }

        return $this;
    }

    public function removeCategory(Category $category): static
    {
        $this->categories->removeElement($category);

        return $this;
    }
}
