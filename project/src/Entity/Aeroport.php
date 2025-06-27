<?php

namespace App\Entity;

use App\Model\Enum\PaysEnum;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\AeroportRepository;
use App\Model\Enum\VillesDestinationEnum;

#[ORM\Entity(repositoryClass: AeroportRepository::class)]
class Aeroport
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(enumType: VillesDestinationEnum::class)]
    private ?VillesDestinationEnum $ville = null;

    #[ORM\Column(enumType: PaysEnum::class)]
    private ?PaysEnum $pays = null;

    /**
     * @var Collection<int, Vol>
     */
    #[ORM\OneToMany(targetEntity: Vol::class, mappedBy: 'aeroportDepart')]
    private Collection $vols;

    public function __construct()
    {
        $this->vols = new ArrayCollection();
    }

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

    public function getVille(): ?VillesDestinationEnum
    {
        return $this->ville;
    }

    public function setVille(VillesDestinationEnum $ville): static
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
            $vol->setAeroportDepart($this);
        }

        return $this;
    }

    public function removeVol(Vol $vol): static
    {
        if ($this->vols->removeElement($vol)) {
            // set the owning side to null (unless already changed)
            if ($vol->getAeroportDepart() === $this) {
                $vol->setAeroportDepart(null);
            }
        }

        return $this;
    }
}
