<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 50)]
    private ?string $nom = null;

    #[ORM\Column(length: 50)]
    private ?string $prenom = null;

    #[ORM\Column(length: 50)]
    private ?string $telephone = null;

    #[ORM\Column(length: 255)]
    private ?string $adresse = null;

    #[ORM\Column(type: 'date')]
    private ?\DateTimeInterface $naissanceAt = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $photo = null;

    #[ORM\Column(length: 50)]
    private ?string $pseudo = null;

    #[ORM\Column(length: 50)]
    private ?string $sexe = null;

    #[ORM\Column]
    private bool $isVerified = false;

    /**
     * @var Collection<int, Voiture>
     */
    #[ORM\OneToMany(targetEntity: Voiture::class, mappedBy: 'user')]
    private Collection $voitures;

    /**
     * @var Collection<int, Couvoiturage>
     */
    #[ORM\OneToMany(targetEntity: Couvoiturage::class, mappedBy: 'driver')]
    private Collection $couvoiturages;

    /**
     * @var Collection<int, Couvoiturage>
     */
    #[ORM\ManyToMany(targetEntity: Couvoiturage::class, mappedBy: 'passagers')]
    private Collection $couvoituragesparticipe;

    public function __construct()
    {
        $this->voitures = new ArrayCollection();
        $this->couvoiturages = new ArrayCollection();
        $this->couvoituragesparticipe = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Ensure the session doesn't contain actual password hashes by CRC32C-hashing them, as supported since Symfony 7.3.
     */
    public function __serialize(): array
    {
        $data = (array) $this;
        $data["\0" . self::class . "\0password"] = hash('crc32c', $this->password);
        
        return $data;
    }

    #[\Deprecated]
    public function eraseCredentials(): void
    {
        // @deprecated, to be removed when upgrading to Symfony 8
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): static
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getNaissanceAt(): ?\DateTimeInterface
    {
        return $this->naissanceAt;
    }

    public function setNaissanceAt(\DateTimeInterface $naissanceAt): static
    {
        $this->naissanceAt = $naissanceAt;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): static
    {
        $this->photo = $photo;

        return $this;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): static
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(string $sexe): static
    {
        $this->sexe = $sexe;

        return $this;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): static
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    /**
     * @return Collection<int, Voiture>
     */
    public function getVoitures(): Collection
    {
        return $this->voitures;
    }

    public function addVoiture(Voiture $voiture): static
    {
        if (!$this->voitures->contains($voiture)) {
            $this->voitures->add($voiture);
            $voiture->setUser($this);
        }

        return $this;
    }

    public function removeVoiture(Voiture $voiture): static
    {
        if ($this->voitures->removeElement($voiture)) {
            // set the owning side to null (unless already changed)
            if ($voiture->getUser() === $this) {
                $voiture->setUser(null);
            }
        }

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
            $couvoiturage->setDriver($this);
        }

        return $this;
    }

    public function removeCouvoiturage(Couvoiturage $couvoiturage): static
    {
        if ($this->couvoiturages->removeElement($couvoiturage)) {
            // set the owning side to null (unless already changed)
            if ($couvoiturage->getDriver() === $this) {
                $couvoiturage->setDriver(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Couvoiturage>
     */
    public function getCouvoituragesparticipe(): Collection
    {
        return $this->couvoituragesparticipe;
    }

    public function addCouvoituragesparticipe(Couvoiturage $couvoituragesparticipe): static
    {
        if (!$this->couvoituragesparticipe->contains($couvoituragesparticipe)) {
            $this->couvoituragesparticipe->add($couvoituragesparticipe);
            $couvoituragesparticipe->addPassager($this);
        }

        return $this;
    }

    public function removeCouvoituragesparticipe(Couvoiturage $couvoituragesparticipe): static
    {
        if ($this->couvoituragesparticipe->removeElement($couvoituragesparticipe)) {
            $couvoituragesparticipe->removePassager($this);
        }

        return $this;
    }
}
