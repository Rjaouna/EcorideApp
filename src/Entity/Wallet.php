<?php

namespace App\Entity;

use App\Repository\WalletRepository;
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
    
}
