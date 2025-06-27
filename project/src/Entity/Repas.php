<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Model\Enum\TypeRepasEnum;
use App\Repository\RepasRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: RepasRepository::class)]
class Repas
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(enumType: TypeRepasEnum::class)]
    private ?TypeRepasEnum $typeRepas = null;

    /**
     * @var Collection<int, RepasVol>
     */
    #[ORM\ManyToMany(targetEntity: RepasVol::class, mappedBy: 'repas')]
    private Collection $repasVols;

    /**
     * @var Collection<int, Personnel>
     */
    #[ORM\ManyToMany(targetEntity: Personnel::class, mappedBy: 'repas')]
    private Collection $personnels;

    public function __construct()
    {
        $this->repasVols = new ArrayCollection();
        $this->personnels = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeRepas(): ?TypeRepasEnum
    {
        return $this->typeRepas;
    }

    public function setTypeRepas(TypeRepasEnum $typeRepas): static
    {
        $this->typeRepas = $typeRepas;

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
            $repasVol->addRepa($this);
        }

        return $this;
    }

    public function removeRepasVol(RepasVol $repasVol): static
    {
        if ($this->repasVols->removeElement($repasVol)) {
            $repasVol->removeRepa($this);
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
            $personnel->addRepa($this);
        }

        return $this;
    }

    public function removePersonnel(Personnel $personnel): static
    {
        if ($this->personnels->removeElement($personnel)) {
            $personnel->removeRepa($this);
        }

        return $this;
    }
}
