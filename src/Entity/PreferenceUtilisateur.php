<?php

namespace App\Entity;

use App\Repository\PreferenceUtilisateurRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PreferenceUtilisateurRepository::class)]
class PreferenceUtilisateur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $politiqueTabac = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $politiqueAnimaux = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $niveauConversation = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $niveauMusique = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $autoriseNourriture = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $autoriseBoissons = null;

    #[ORM\Column(nullable: true)]
    private ?int $tailleMaxBagages = null;

    #[ORM\OneToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPolitiqueTabac(): ?string
    {
        return $this->politiqueTabac;
    }

    public function setPolitiqueTabac(?string $politiqueTabac): static
    {
        $this->politiqueTabac = $politiqueTabac;

        return $this;
    }

    public function getPolitiqueAnimaux(): ?string
    {
        return $this->politiqueAnimaux;
    }

    public function setPolitiqueAnimaux(?string $politiqueAnimaux): static
    {
        $this->politiqueAnimaux = $politiqueAnimaux;

        return $this;
    }

    public function getNiveauConversation(): ?string
    {
        return $this->niveauConversation;
    }

    public function setNiveauConversation(?string $niveauConversation): static
    {
        $this->niveauConversation = $niveauConversation;

        return $this;
    }

    public function getNiveauMusique(): ?string
    {
        return $this->niveauMusique;
    }

    public function setNiveauMusique(?string $niveauMusique): static
    {
        $this->niveauMusique = $niveauMusique;

        return $this;
    }

    public function getAutoriseNourriture(): ?string
    {
        return $this->autoriseNourriture;
    }

    public function setAutoriseNourriture(?string $autoriseNourriture): static
    {
        $this->autoriseNourriture = $autoriseNourriture;

        return $this;
    }

    public function getAutoriseBoissons(): ?string
    {
        return $this->autoriseBoissons;
    }

    public function setAutoriseBoissons(?string $autoriseBoissons): static
    {
        $this->autoriseBoissons = $autoriseBoissons;

        return $this;
    }

    public function getTailleMaxBagages(): ?int
    {
        return $this->tailleMaxBagages;
    }

    public function setTailleMaxBagages(?int $tailleMaxBagages): static
    {
        $this->tailleMaxBagages = $tailleMaxBagages;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): static
    {
        $this->user = $user;

        return $this;
    }
}
