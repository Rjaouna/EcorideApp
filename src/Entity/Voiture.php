<?php

namespace App\Entity;

use App\Repository\VoitureRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VoitureRepository::class)]
class Voiture
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'voitures')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Marque $marque = null;

    #[ORM\Column(length: 50)]
    private ?string $modele = null;

    #[ORM\Column(length: 50)]
    private ?string $immatriculation = null;

    #[ORM\Column(length: 50)]
    private ?string $energie = null;

    #[ORM\Column(length: 50)]
    private ?string $couleur = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $immatriculationAt = null;

    #[ORM\ManyToOne(inversedBy: 'voitures')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column]
    private ?int $nombrePlaces = null;

    #[ORM\Column(nullable: true)]
    private ?bool $isLocked = null;

    /**
     * @var Collection<int, Couvoiturage>
     */
    #[ORM\OneToMany(targetEntity: Couvoiturage::class, mappedBy: 'voiture')]
    private Collection $couvoiturages;

    public function __construct()
    {
        $this->couvoiturages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMarque(): ?Marque
    {
        return $this->marque;
    }

    public function setMarque(?Marque $marque): static
    {
        $this->marque = $marque;

        return $this;
    }

    public function getModele(): ?string
    {
        return $this->modele;
    }

    public function setModele(string $modele): static
    {
        $this->modele = $modele;

        return $this;
    }

    public function getImmatriculation(): ?string
    {
        return $this->immatriculation;
    }

    public function setImmatriculation(string $immatriculation): static
    {
        $this->immatriculation = $immatriculation;

        return $this;
    }

    public function getEnergie(): ?string
    {
        return $this->energie;
    }

    public function setEnergie(string $energie): static
    {
        $this->energie = $energie;

        return $this;
    }

    public function getCouleur(): ?string
    {
        return $this->couleur;
    }

    public function setCouleur(string $couleur): static
    {
        $this->couleur = $couleur;

        return $this;
    }

    public function getImmatriculationAt(): ?\DateTimeImmutable
    {
        return $this->immatriculationAt;
    }

    public function setImmatriculationAt(\DateTimeImmutable $immatriculationAt): static
    {
        $this->immatriculationAt = $immatriculationAt;

        return $this;
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

    public function getNombrePlaces(): ?int
    {
        return $this->nombrePlaces;
    }

    public function setNombrePlaces(int $nombrePlaces): static
    {
        $this->nombrePlaces = $nombrePlaces;

        return $this;
    }

    public function isLocked(): ?bool
    {
        return $this->isLocked;
    }

    public function setIsLocked(?bool $isLocked): static
    {
        $this->isLocked = $isLocked;

        return $this;
    }

    /**
     * @return Collection<int, Couvoiturage>
     */
    public function getCouvoiturages(): Collection
    {
        return $this->couvoiturages;
    }

    public function addCouvoiturage(Couvoiturage $couvoiturage): static
    {
        if (!$this->couvoiturages->contains($couvoiturage)) {
            $this->couvoiturages->add($couvoiturage);
            $couvoiturage->setVoiture($this);
        }

        return $this;
    }

    public function removeCouvoiturage(Couvoiturage $couvoiturage): static
    {
        if ($this->couvoiturages->removeElement($couvoiturage)) {
            // set the owning side to null (unless already changed)
            if ($couvoiturage->getVoiture() === $this) {
                $couvoiturage->setVoiture(null);
            }
        }

        return $this;
    }
}
