<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\EscalesRepository;
use App\Model\Enum\VillesDestinationEnum;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: EscalesRepository::class)]
class Escales
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, Vol>
     */
    #[ORM\ManyToMany(targetEntity: Vol::class, inversedBy: 'escales')]
    private Collection $vol;

    #[ORM\Column]
    private ?int $dureeEscale = null;

    #[ORM\Column(enumType: VillesDestinationEnum::class)]
    private ?VillesDestinationEnum $villeEscale = null;

    public function __construct()
    {
        $this->vol = new ArrayCollection();
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

    public function getDureeEscale(): ?int
    {
        return $this->dureeEscale;
    }

    public function setDureeEscale(int $dureeEscale): static
    {
        $this->dureeEscale = $dureeEscale;

        return $this;
    }

    public function getVilleEscale(): ?VillesDestinationEnum
    {
        return $this->villeEscale;
    }

    public function setVilleEscale(VillesDestinationEnum $villeEscale): static
    {
        $this->villeEscale = $villeEscale;

        return $this;
    }
}
