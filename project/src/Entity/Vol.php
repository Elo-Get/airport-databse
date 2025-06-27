<?php

namespace App\Entity;

use OpenApi\Attributes as OA;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;
use App\Model\Enum\TypeVolEnum;
use App\Model\Enum\StatutVolEnum;
use App\Repository\VolRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;


#[ORM\Entity(repositoryClass: VolRepository::class)]
#[OA\Schema(
    title: 'Vol',
    description: 'Représente un vol',
    type: 'object',
    schema: 'Vol',
    properties: [
        new OA\Property(property: 'id', type: 'integer', description: 'Identifiant du vol'),
        new OA\Property(property: 'avion', ref: '#/components/schemas/Avion'),
        new OA\Property(property: 'dateDepart', type: 'string', format: 'date-time'),
        new OA\Property(property: 'dateArrivee', type: 'string', format: 'date-time'),
        new OA\Property(property: 'distanceKm', type: 'integer'),
        new OA\Property(property: 'typeVol', ref: '#/components/schemas/TypeVolEnum'),
        new OA\Property(property: 'prixBase', type: 'number', format: 'float'),
        new OA\Property(property: 'statutVol', ref: '#/components/schemas/StatutVolEnum'),
        new OA\Property(property: 'raisonRetard', type: 'string', nullable: true),
    ]
)]
class Vol
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[OA\Property(type: 'integer', description: 'Identifiant du vol')]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'vols')]
    #[OA\Property(ref: '#/components/schemas/Avion', description: 'Avion associé au vol')]
    private ?Avion $avion = null;

    #[ORM\Column]
    #[OA\Property(type: 'string', format: 'date-time', description: 'Date et heure de départ du vol')]
    private ?\DateTime $dateDepart = null;

    #[ORM\Column]
    #[OA\Property(type: 'string', format: 'date-time', description: 'Date et heure d’arrivée du vol')]
    private ?\DateTime $dateArrivee = null;

    #[ORM\Column]
    #[OA\Property(type: 'integer', description: 'Distance du vol en kilomètres')]
    private ?int $distanceKm = null;

    #[ORM\Column(enumType: TypeVolEnum::class)]
    #[OA\Property(ref: '#/components/schemas/TypeVolEnum', description: 'Type de vol (direct, escale)')]
    private ?TypeVolEnum $typeVol = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 0)]
    #[OA\Property(type: 'number', format: 'float', description: 'Prix de base du vol')]
    private ?string $prixBase = null;

   #[ORM\Column(enumType: StatutVolEnum::class)]
    #[OA\Property(
        ref: '#/components/schemas/StatutVolEnum',
        description: 'Statut du vol (prévu, retardé, annulé)'
    )]
    private ?StatutVolEnum $statutVol = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[OA\Property(
        type: 'string',
        description: 'Raison du retard du vol',
        nullable: true
    )]
    private ?string $raisonRetard = null;

    /**
     * @var Collection<int, Billet>
     */
    #[ORM\OneToMany(targetEntity: Billet::class, mappedBy: 'vol')]
    #[OA\Property(
        type: 'array',
        description: 'Billets émis pour ce vol',
        items: new OA\Items(ref: '#/components/schemas/Billet')
    )]
    private Collection $billets;

    /**
     * @var Collection<int, RepasVol>
     */
    #[ORM\ManyToMany(targetEntity: RepasVol::class, mappedBy: 'vol')]
    #[OA\Property(
        type: 'array',
        description: 'Repas disponibles à bord',
        items: new OA\Items(ref: '#/components/schemas/RepasVol')
    )]
    private Collection $repasVols;

    /**
     * @var Collection<int, Escales>
     */
    #[ORM\ManyToMany(targetEntity: Escales::class, mappedBy: 'vol')]
    #[OA\Property(
        type: 'array',
        description: 'Escales pour ce vol',
        items: new OA\Items(ref: '#/components/schemas/Escales')
    )]
    private Collection $escales;

    /**
     * @var Collection<int, Personnel>
     */
    #[ORM\ManyToMany(targetEntity: Personnel::class, mappedBy: 'vols')]
    #[OA\Property(
        type: 'array',
        description: 'Équipage assigné à ce vol',
        items: new OA\Items(ref: '#/components/schemas/Personnel')
    )]
    private Collection $personnels;

    #[ORM\ManyToOne(inversedBy: 'vols')]
    #[ORM\JoinColumn(nullable: false)]
    #[OA\Property(
        ref: '#/components/schemas/Aeroport',
        description: 'Aéroport de départ'
    )]
    private ?Aeroport $aeroportDepart = null;

    #[ORM\ManyToOne(inversedBy: 'vols')]
    #[ORM\JoinColumn(nullable: false)]
    #[OA\Property(
        ref: '#/components/schemas/Aeroport',
        description: 'Aéroport d’arrivée'
    )]
    private ?Aeroport $aeroportArrive = null;

    public function __construct()
    {
        $this->billets = new ArrayCollection();
        $this->repasVols = new ArrayCollection();
        $this->escales = new ArrayCollection();
        $this->personnels = new ArrayCollection();
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
    public function getBillets(): Collection
    {
        return $this->billets;
    }

    public function addBillet(Billet $billet): static
    {
        if (!$this->billets->contains($billet)) {
            $this->billets->add($billet);
            $billet->setVol($this);
        }

        return $this;
    }

    public function removeBillet(Billet $billet): static
    {
        if ($this->billets->removeElement($billet)) {
            // set the owning side to null (unless already changed)
            if ($billet->getVol() === $this) {
                $billet->setVol(null);
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

    /**
     * @return Collection<int, Personnel>
     */
    public function getPersonnels(): Collection
    {
        return $this->personnels;
    }

    public function addPersonnel(Personnel $personnel): static
    {
        if (!$this->personnels->contains($personnel)) {
            $this->personnels->add($personnel);
            $personnel->addVol($this);
        }

        return $this;
    }

    public function removePersonnel(Personnel $personnel): static
    {
        if ($this->personnels->removeElement($personnel)) {
            $personnel->removeVol($this);
        }

        return $this;
    }

    public function getAeroportDepart(): ?Aeroport
    {
        return $this->aeroportDepart;
    }

    public function setAeroportDepart(?Aeroport $aeroportDepart): static
    {
        $this->aeroportDepart = $aeroportDepart;

        return $this;
    }

    public function getAeroportArrive(): ?Aeroport
    {
        return $this->aeroportArrive;
    }

    public function setAeroportArrive(?Aeroport $aeroportArrive): static
    {
        $this->aeroportArrive = $aeroportArrive;

        return $this;
    }
}
