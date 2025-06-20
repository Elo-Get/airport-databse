<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;
use App\Model\Enum\TypePaiementEnum;
use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'commandes')]
    private ?Client $client = null;

    #[ORM\Column]
    private ?\DateTime $dateCommande = null;

    #[ORM\Column(enumType: TypePaiementEnum::class)]
    private ?TypePaiementEnum $moyentPaiement = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 0)]
    private ?string $prixTotal = null;

    #[ORM\Column]
    private ?bool $assuranceAnnulation = null;

    /**
     * @var Collection<int, Billet>
     */
    #[ORM\OneToMany(targetEntity: Billet::class, mappedBy: 'commande')]
    private Collection $vol;

    public function __construct()
    {
        $this->vol = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): static
    {
        $this->client = $client;

        return $this;
    }

    public function getDateCommande(): ?\DateTime
    {
        return $this->dateCommande;
    }

    public function setDateCommande(\DateTime $dateCommande): static
    {
        $this->dateCommande = $dateCommande;

        return $this;
    }

    public function getMoyentPaiement(): ?TypePaiementEnum
    {
        return $this->moyentPaiement;
    }

    public function setMoyentPaiement(TypePaiementEnum $moyentPaiement): static
    {
        $this->moyentPaiement = $moyentPaiement;

        return $this;
    }

    public function getPrixTotal(): ?string
    {
        return $this->prixTotal;
    }

    public function setPrixTotal(string $prixTotal): static
    {
        $this->prixTotal = $prixTotal;

        return $this;
    }

    public function isAssuranceAnnulation(): ?bool
    {
        return $this->assuranceAnnulation;
    }

    public function setAssuranceAnnulation(bool $assuranceAnnulation): static
    {
        $this->assuranceAnnulation = $assuranceAnnulation;

        return $this;
    }

    /**
     * @return Collection<int, Billet>
     */
    public function getVol(): Collection
    {
        return $this->vol;
    }

    public function addVol(Billet $vol): static
    {
        if (!$this->vol->contains($vol)) {
            $this->vol->add($vol);
            $vol->setCommande($this);
        }

        return $this;
    }

    public function removeVol(Billet $vol): static
    {
        if ($this->vol->removeElement($vol)) {
            // set the owning side to null (unless already changed)
            if ($vol->getCommande() === $this) {
                $vol->setCommande(null);
            }
        }

        return $this;
    }
}
