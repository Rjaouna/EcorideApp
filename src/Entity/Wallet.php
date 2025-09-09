<?php

namespace App\Entity;

use App\Repository\WalletRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WalletRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Wallet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'wallet', cascade: ['persist', 'remove'])]
    private ?User $user = null;

    #[ORM\Column(nullable: true)]
    private ?float $soldeDisponible = null;

    #[ORM\Column(nullable: true)]
    private ?float $soldeEnAttente = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    /**
     * @var Collection<int, Couvoiturage>
     */
    #[ORM\ManyToMany(targetEntity: Couvoiturage::class, inversedBy: 'wallets')]
    private Collection $couvoiturage;

    public function __construct()
    {
        $this->couvoiturage = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getSoldeDisponible(): ?float
    {
        return $this->soldeDisponible;
    }

    public function setSoldeDisponible(?float $soldeDisponible): static
    {
        $this->soldeDisponible = $soldeDisponible;

        return $this;
    }

    public function getSoldeEnAttente(): ?float
    {
        return $this->soldeEnAttente;
    }

    public function setSoldeEnAttente(?float $soldeEnAttente): static
    {
        $this->soldeEnAttente = $soldeEnAttente;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
    #[ORM\PrePersist]
    public function onPrePersist(): void
    {
        $this->setSoldeDisponible(20);
        $this->setSoldeEnAttente(0);
        $this->updatedAt = new \DateTimeImmutable();
    }
    #[ORM\PreUpdate]
    public function onPreUpdate(): void
    {
        $this->updatedAt = new \DateTimeImmutable();
    }

    /**
     * @return Collection<int, Couvoiturage>
     */
    public function getCouvoiturage(): Collection
    {
        return $this->couvoiturage;
    }

    public function addCouvoiturage(Couvoiturage $couvoiturage): static
    {
        if (!$this->couvoiturage->contains($couvoiturage)) {
            $this->couvoiturage->add($couvoiturage);
        }

        return $this;
    }

    public function removeCouvoiturage(Couvoiturage $couvoiturage): static
    {
        $this->couvoiturage->removeElement($couvoiturage);

        return $this;
    }
    
}
