<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;
use App\Repository\CarteFideliteRepository;

#[ORM\Entity(repositoryClass: CarteFideliteRepository::class)]
class CarteFidelite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'carteFidelites')]
    private ?Client $idClient = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $dateObtention = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdClient(): ?Client
    {
        return $this->idClient;
    }

    public function setIdClient(?Client $idClient): static
    {
        $this->idClient = $idClient;

        return $this;
    }

    public function getDateObtention(): ?\DateTime
    {
        return $this->dateObtention;
    }

    public function setDateObtention(\DateTime $dateObtention): static
    {
        $this->dateObtention = $dateObtention;

        return $this;
    }
}
