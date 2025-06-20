<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;
use App\Model\Enum\TypeAvionEnum;
use App\Repository\AvionRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: AvionRepository::class)]
class Avion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(enumType: TypeAvionEnum::class)]
    private ?TypeAvionEnum $typeAvion = null;

    #[ORM\Column]
    private ?int $capacite = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $dateMiseEnService = null;

    /**
     * @var Collection<int, Entretien>
     */
    #[ORM\OneToMany(targetEntity: Entretien::class, mappedBy: 'avion', orphanRemoval: true)]
    private Collection $entretiens;

    /**
     * @var Collection<int, Vol>
     */
    #[ORM\OneToMany(targetEntity: Vol::class, mappedBy: 'avion')]
    private Collection $vols;

    public function __construct()
    {
        $this->entretiens = new ArrayCollection();
        $this->vols = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeAvion(): ?TypeAvionEnum
    {
        return $this->typeAvion;
    }

    public function setTypeAvion(TypeAvionEnum $typeAvion): static
    {
        $this->typeAvion = $typeAvion;

        return $this;
    }

    public function getCapacite(): ?int
    {
        return $this->capacite;
    }

    public function setCapacite(int $capacite): static
    {
        $this->capacite = $capacite;

        return $this;
    }

    public function getDateMiseEnService(): ?\DateTime
    {
        return $this->dateMiseEnService;
    }

    public function setDateMiseEnService(\DateTime $dateMiseEnService): static
    {
        $this->dateMiseEnService = $dateMiseEnService;

        return $this;
    }

    /**
     * @return Collection<int, Entretien>
     */
    public function getEntretiens(): Collection
    {
        return $this->entretiens;
    }

    public function addEntretien(Entretien $entretien): static
    {
        if (!$this->entretiens->contains($entretien)) {
            $this->entretiens->add($entretien);
            $entretien->setAvion($this);
        }

        return $this;
    }

    public function removeEntretien(Entretien $entretien): static
    {
        if ($this->entretiens->removeElement($entretien)) {
            // set the owning side to null (unless already changed)
            if ($entretien->getAvion() === $this) {
                $entretien->setAvion(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Vol>
     */
    public function getVols(): Collection
    {
        return $this->vols;
    }

    public function addVol(Vol $vol): static
    {
        if (!$this->vols->contains($vol)) {
            $this->vols->add($vol);
            $vol->setAvion($this);
        }

        return $this;
    }

    public function removeVol(Vol $vol): static
    {
        if ($this->vols->removeElement($vol)) {
            // set the owning side to null (unless already changed)
            if ($vol->getAvion() === $this) {
                $vol->setAvion(null);
            }
        }

        return $this;
    }
}
