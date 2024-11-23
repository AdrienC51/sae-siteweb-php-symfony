<?php

namespace App\Entity;

use App\Repository\AdminRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AdminRepository::class)]
class Admin
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'admin', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Account $account = null;

    /**
     * @var Collection<int, Restocking>
     */
    #[ORM\OneToMany(targetEntity: Restocking::class, mappedBy: 'admin')]
    private Collection $Restockings;

    public function __construct()
    {
        $this->Restockings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAccount(): ?Account
    {
        return $this->account;
    }

    public function setAccount(Account $account): static
    {
        $this->account = $account;

        return $this;
    }

    /**
     * @return Collection<int, Restocking>
     */
    public function getRestockings(): Collection
    {
        return $this->Restockings;
    }

    public function addRestocking(Restocking $restocking): static
    {
        if (!$this->Restockings->contains($restocking)) {
            $this->Restockings->add($restocking);
            $restocking->setAdmin($this);
        }

        return $this;
    }

    public function removeRestocking(Restocking $restocking): static
    {
        if ($this->Restockings->removeElement($restocking)) {
            // set the owning side to null (unless already changed)
            if ($restocking->getAdmin() === $this) {
                $restocking->setAdmin(null);
            }
        }

        return $this;
    }
}
