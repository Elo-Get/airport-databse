<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;
use App\Model\Enum\TypeEntretienEnum;
use App\Model\Enum\StatutEntretienEnum;
use App\Repository\EntretienRepository;

#[ORM\Entity(repositoryClass: EntretienRepository::class)]
class Entretien
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'entretiens')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Avion $avion = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $dateEntretien = null;

    #[ORM\Column(enumType: TypeEntretienEnum::class)]
    private ?TypeEntretienEnum $typeEntretien = null;

    #[ORM\Column(enumType: StatutEntretienEnum::class)]
    private ?StatutEntretienEnum $statutEntretien = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $commentaire = null;

    /**
     * @var Collection<int, Personnel>
     */
    #[ORM\ManyToMany(targetEntity: Personnel::class, mappedBy: 'entretiens')]
    private Collection $personnels;

    public function __construct()
    {
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

    public function getDateEntretien(): ?\DateTime
    {
        return $this->dateEntretien;
    }

    public function setDateEntretien(\DateTime $dateEntretien): static
    {
        $this->dateEntretien = $dateEntretien;

        return $this;
    }

    public function getTypeEntretien(): ?TypeEntretienEnum
    {
        return $this->typeEntretien;
    }

    public function setTypeEntretien(TypeEntretienEnum $typeEntretien): static
    {
        $this->typeEntretien = $typeEntretien;

        return $this;
    }

    public function getStatutEntretien(): ?StatutEntretienEnum
    {
        return $this->statutEntretien;
    }

    public function setStatutEntretien(StatutEntretienEnum $statutEntretien): static
    {
        $this->statutEntretien = $statutEntretien;

        return $this;
    }

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(?string $commentaire): static
    {
        $this->commentaire = $commentaire;

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
            $personnel->addEntretien($this);
        }

        return $this;
    }

    public function removePersonnel(Personnel $personnel): static
    {
        if ($this->personnels->removeElement($personnel)) {
            $personnel->removeEntretien($this);
        }

        return $this;
    }
}
