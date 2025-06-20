<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;
use App\Model\Enum\TypeVolEnum;
use App\Model\Enum\StatutVolEnum;
use App\Repository\VolRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: VolRepository::class)]
class Vol
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'vols')]
    private ?Avion $avion = null;

    #[ORM\Column]
    private ?\DateTime $dateDepart = null;

    #[ORM\Column]
    private ?\DateTime $dateArrivee = null;

    #[ORM\Column]
    private ?int $distanceKm = null;

    #[ORM\Column(enumType: TypeVolEnum::class)]
    private ?TypeVolEnum $typeVol = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 0)]
    private ?string $prixBase = null;

    #[ORM\Column(enumType: StatutVolEnum::class)]
    private ?StatutVolEnum $statutVol = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $raisonRetard = null;

    /**
     * @var Collection<int, Billet>
     */
    #[ORM\OneToMany(targetEntity: Billet::class, mappedBy: 'vol')]
    private Collection $client;

    /**
     * @var Collection<int, RepasVol>
     */
    #[ORM\ManyToMany(targetEntity: RepasVol::class, mappedBy: 'vol')]
    private Collection $repasVols;

    /**
     * @var Collection<int, Escales>
     */
    #[ORM\ManyToMany(targetEntity: Escales::class, mappedBy: 'vol')]
    private Collection $escales;

    public function __construct()
    {
        $this->client = new ArrayCollection();
        $this->repasVols = new ArrayCollection();
        $this->escales = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAvion(): ?Avion
    {
        return $this->avion;
    }

    public function setAvion(?Avion $avion): static
    {
        $this->avion = $avion;

        return $this;
    }

    public function getDateDepart(): ?\DateTime
    {
        return $this->dateDepart;
    }

    public function setDateDepart(\DateTime $dateDepart): static
    {
        $this->dateDepart = $dateDepart;

        return $this;
    }

    public function getDateArrivee(): ?\DateTime
    {
        return $this->dateArrivee;
    }

    public function setDateArrivee(\DateTime $dateArrivee): static
    {
        $this->dateArrivee = $dateArrivee;

        return $this;
    }

    public function getDistanceKm(): ?int
    {
        return $this->distanceKm;
    }

    public function setDistanceKm(int $distanceKm): static
    {
        $this->distanceKm = $distanceKm;

        return $this;
    }

    public function getTypeVol(): ?TypeVolEnum
    {
        return $this->typeVol;
    }

    public function setTypeVol(TypeVolEnum $typeVol): static
    {
        $this->typeVol = $typeVol;

        return $this;
    }

    public function getPrixBase(): ?string
    {
        return $this->prixBase;
    }

    public function setPrixBase(string $prixBase): static
    {
        $this->prixBase = $prixBase;

        return $this;
    }

    public function getStatutVol(): ?StatutVolEnum
    {
        return $this->statutVol;
    }

    public function setStatutVol(StatutVolEnum $statutVol): static
    {
        $this->statutVol = $statutVol;

        return $this;
    }

    public function getRaisonRetard(): ?string
    {
        return $this->raisonRetard;
    }

    public function setRaisonRetard(?string $raisonRetard): static
    {
        $this->raisonRetard = $raisonRetard;

        return $this;
    }

    /**
     * @return Collection<int, Billet>
     */
    public function getClient(): Collection
    {
        return $this->client;
    }

    public function addClient(Billet $client): static
    {
        if (!$this->client->contains($client)) {
            $this->client->add($client);
            $client->setVol($this);
        }

        return $this;
    }

    public function removeClient(Billet $client): static
    {
        if ($this->client->removeElement($client)) {
            // set the owning side to null (unless already changed)
            if ($client->getVol() === $this) {
                $client->setVol(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, RepasVol>
     */
    public function getRepasVols(): Collection
    {
        return $this->repasVols;
    }

    public function addRepasVol(RepasVol $repasVol): static
    {
        if (!$this->repasVols->contains($repasVol)) {
            $this->repasVols->add($repasVol);
            $repasVol->addVol($this);
        }

        return $this;
    }

    public function removeRepasVol(RepasVol $repasVol): static
    {
        if ($this->repasVols->removeElement($repasVol)) {
            $repasVol->removeVol($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Escales>
     */
    public function getEscales(): Collection
    {
        return $this->escales;
    }

    public function addEscale(Escales $escale): static
    {
        if (!$this->escales->contains($escale)) {
            $this->escales->add($escale);
            $escale->addVol($this);
        }

        return $this;
    }

    public function removeEscale(Escales $escale): static
    {
        if ($this->escales->removeElement($escale)) {
            $escale->removeVol($this);
        }

        return $this;
    }
}
