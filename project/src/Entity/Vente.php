<?php

namespace App\Entity;

use App\Repository\VenteRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VenteRepository::class)]
class Vente
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $mois = null;

    #[ORM\Column]
    private ?int $annee = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 0)]
    private ?string $chiffreAffaire = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMois(): ?int
    {
        return $this->mois;
    }

    public function setMois(int $mois): static
    {
        $this->mois = $mois;

        return $this;
    }

    public function getAnnee(): ?int
    {
        return $this->annee;
    }

    public function setAnnee(int $annee): static
    {
        $this->annee = $annee;

        return $this;
    }

    public function getChiffreAffaire(): ?string
    {
        return $this->chiffreAffaire;
    }

    public function setChiffreAffaire(string $chiffreAffaire): static
    {
        $this->chiffreAffaire = $chiffreAffaire;

        return $this;
    }
}
