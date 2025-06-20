<?php

namespace App\Entity;

use App\Repository\RepasVolRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RepasVolRepository::class)]
class RepasVol
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, Vol>
     */
    #[ORM\ManyToMany(targetEntity: Vol::class, inversedBy: 'repasVols')]
    private Collection $vol;

    /**
     * @var Collection<int, Repas>
     */
    #[ORM\ManyToMany(targetEntity: Repas::class, inversedBy: 'repasVols')]
    private Collection $repas;

    #[ORM\Column]
    private ?int $quantite = null;

    public function __construct()
    {
        $this->vol = new ArrayCollection();
        $this->repas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Vol>
     */
    public function getVol(): Collection
    {
        return $this->vol;
    }

    public function addVol(Vol $vol): static
    {
        if (!$this->vol->contains($vol)) {
            $this->vol->add($vol);
        }

        return $this;
    }

    public function removeVol(Vol $vol): static
    {
        $this->vol->removeElement($vol);

        return $this;
    }

    /**
     * @return Collection<int, Repas>
     */
    public function getRepas(): Collection
    {
        return $this->repas;
    }

    public function addRepa(Repas $repa): static
    {
        if (!$this->repas->contains($repa)) {
            $this->repas->add($repa);
        }

        return $this;
    }

    public function removeRepa(Repas $repa): static
    {
        $this->repas->removeElement($repa);

        return $this;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): static
    {
        $this->quantite = $quantite;

        return $this;
    }
}
