<?php

namespace App\Entity;

use App\Model\Enum\PaysEnum;
use Doctrine\ORM\Mapping as ORM;
use App\Model\Enum\TypeVolEnum;
use App\Repository\AeroportRepository;

#[ORM\Entity(repositoryClass: AeroportRepository::class)]
class Aeroport
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(enumType: TypeVolEnum::class)]
    private ?TypeVolEnum $ville = null;

    #[ORM\Column(enumType: PaysEnum::class)]
    private ?PaysEnum $pays = null;

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

    public function getVille(): ?TypeVolEnum
    {
        return $this->ville;
    }

    public function setVille(TypeVolEnum $ville): static
    {
        $this->ville = $ville;

        return $this;
    }

    public function getPays(): ?PaysEnum
    {
        return $this->pays;
    }

    public function setPays(PaysEnum $pays): static
    {
        $this->pays = $pays;

        return $this;
    }
}
