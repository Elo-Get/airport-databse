<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;
use App\Model\Enum\TypeBilletEnum;
use App\Repository\BilletRepository;

#[ORM\Entity(repositoryClass: BilletRepository::class)]
class Billet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'vol')]
    private ?Commande $commande = null;

    #[ORM\ManyToOne(inversedBy: 'client')]
    private ?Vol $vol = null;

    #[ORM\ManyToOne(inversedBy: 'billets')]
    private ?Client $client = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 0)]
    private ?string $prixEffectif = null;

    #[ORM\Column(enumType: TypeBilletEnum::class)]
    private ?TypeBilletEnum $classe = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $nbBagagesSoute = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCommande(): ?Commande
    {
        return $this->commande;
    }

    public function setCommande(?Commande $commande): static
    {
        $this->commande = $commande;

        return $this;
    }

    public function getVol(): ?Vol
    {
        return $this->vol;
    }

    public function setVol(?Vol $vol): static
    {
        $this->vol = $vol;

        return $this;
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

    public function getPrixEffectif(): ?string
    {
        return $this->prixEffectif;
    }

    public function setPrixEffectif(string $prixEffectif): static
    {
        $this->prixEffectif = $prixEffectif;

        return $this;
    }

    public function getClasse(): ?TypeBilletEnum
    {
        return $this->classe;
    }

    public function setClasse(TypeBilletEnum $classe): static
    {
        $this->classe = $classe;

        return $this;
    }

    public function getNbBagagesSoute(): ?int
    {
        return $this->nbBagagesSoute;
    }

    public function setNbBagagesSoute(int $nbBagagesSoute): static
    {
        $this->nbBagagesSoute = $nbBagagesSoute;

        return $this;
    }
}
