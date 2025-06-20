<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;
use App\Repository\ClientRepository;
use App\Model\Enum\TypeDocVoyageEnum;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
class Client
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $dateNaissance = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $adressePostale = null;

    #[ORM\Column(length: 255)]
    private ?string $numDocVoyage = null;

    #[ORM\Column(enumType: TypeDocVoyageEnum::class)]
    private ?TypeDocVoyageEnum $typeDocVoyage = null;

    #[ORM\Column(nullable: true)]
    private ?int $nbMiles = 1;

    #[ORM\OneToOne(mappedBy: 'idClient', cascade: ['persist', 'remove'])]
    private ?CompteVoyageur $login = null;

    /**
     * @var Collection<int, CarteFidelite>
     */
    #[ORM\OneToMany(targetEntity: CarteFidelite::class, mappedBy: 'idClient')]
    private Collection $carteFidelites;

    /**
     * @var Collection<int, Commande>
     */
    #[ORM\OneToMany(targetEntity: Commande::class, mappedBy: 'client')]
    private Collection $commandes;

    /**
     * @var Collection<int, Billet>
     */
    #[ORM\OneToMany(targetEntity: Billet::class, mappedBy: 'client')]
    private Collection $billets;

    public function __construct()
    {
        $this->carteFidelites = new ArrayCollection();
        $this->commandes = new ArrayCollection();
        $this->billets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDateNaissance(): ?\DateTime
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(\DateTime $dateNaissance): static
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
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

    public function getAdressePostale(): ?string
    {
        return $this->adressePostale;
    }

    public function setAdressePostale(?string $adressePostale): static
    {
        $this->adressePostale = $adressePostale;

        return $this;
    }

    public function getNumDocVoyage(): ?string
    {
        return $this->numDocVoyage;
    }

    public function setNumDocVoyage(string $numDocVoyage): static
    {
        $this->numDocVoyage = $numDocVoyage;

        return $this;
    }

    public function getTypeDocVoyage(): ?TypeDocVoyageEnum
    {
        return $this->typeDocVoyage;
    }

    public function setTypeDocVoyage(TypeDocVoyageEnum $typeDocVoyage): static
    {
        $this->typeDocVoyage = $typeDocVoyage;

        return $this;
    }

    public function getNbMiles(): ?int
    {
        return $this->nbMiles;
    }

    public function setNbMiles(?int $nbMiles): static
    {
        $this->nbMiles = $nbMiles;

        return $this;
    }

    public function getLogin(): ?CompteVoyageur
    {
        return $this->login;
    }

    public function setLogin(?CompteVoyageur $login): static
    {
        // unset the owning side of the relation if necessary
        if ($login === null && $this->login !== null) {
            $this->login->setIdClient(null);
        }

        // set the owning side of the relation if necessary
        if ($login !== null && $login->getIdClient() !== $this) {
            $login->setIdClient($this);
        }

        $this->login = $login;

        return $this;
    }

    /**
     * @return Collection<int, CarteFidelite>
     */
    public function getCarteFidelites(): Collection
    {
        return $this->carteFidelites;
    }

    public function addCarteFidelite(CarteFidelite $carteFidelite): static
    {
        if (!$this->carteFidelites->contains($carteFidelite)) {
            $this->carteFidelites->add($carteFidelite);
            $carteFidelite->setIdClient($this);
        }

        return $this;
    }

    public function removeCarteFidelite(CarteFidelite $carteFidelite): static
    {
        if ($this->carteFidelites->removeElement($carteFidelite)) {
            // set the owning side to null (unless already changed)
            if ($carteFidelite->getIdClient() === $this) {
                $carteFidelite->setIdClient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Commande>
     */
    public function getCommandes(): Collection
    {
        return $this->commandes;
    }

    public function addCommande(Commande $commande): static
    {
        if (!$this->commandes->contains($commande)) {
            $this->commandes->add($commande);
            $commande->setClient($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): static
    {
        if ($this->commandes->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getClient() === $this) {
                $commande->setClient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Billet>
     */
    public function getBillets(): Collection
    {
        return $this->billets;
    }

    public function addBillet(Billet $billet): static
    {
        if (!$this->billets->contains($billet)) {
            $this->billets->add($billet);
            $billet->setClient($this);
        }

        return $this;
    }

    public function removeBillet(Billet $billet): static
    {
        if ($this->billets->removeElement($billet)) {
            // set the owning side to null (unless already changed)
            if ($billet->getClient() === $this) {
                $billet->setClient(null);
            }
        }

        return $this;
    }
}
