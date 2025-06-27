<?php

namespace App\Entity;

use App\Model\Enum\TypePosteEnum;
use App\Repository\PersonnelRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PersonnelRepository::class)]
class Personnel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\Column(type: Types::SIMPLE_ARRAY, enumType: TypePosteEnum::class)]
    private array $fonction = [];

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $dateEmbauche = null;

    /**
     * @var Collection<int, AffectationPersonnel>
     */
    #[ORM\ManyToMany(targetEntity: AffectationPersonnel::class, mappedBy: 'personnel')]
    private Collection $affectationPersonnels;

    /**
     * @var Collection<int, Vol>
     */
    #[ORM\ManyToMany(targetEntity: Vol::class, inversedBy: 'personnels')]
    private Collection $vols;

    /**
     * @var Collection<int, Repas>
     */
    #[ORM\ManyToMany(targetEntity: Repas::class, inversedBy: 'personnels')]
    private Collection $repas;

    /**
     * @var Collection<int, Entretien>
     */
    #[ORM\ManyToMany(targetEntity: Entretien::class, inversedBy: 'personnels')]
    private Collection $entretiens;

    public function __construct()
    {
        $this->affectationPersonnels = new ArrayCollection();
        $this->vols = new ArrayCollection();
        $this->repas = new ArrayCollection();
        $this->entretiens = new ArrayCollection();
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * @return TypePosteEnum[]
     */
    public function getFonction(): array
    {
        return $this->fonction;
    }

    public function setFonction(array $fonction): static
    {
        $this->fonction = $fonction;

        return $this;
    }

    public function getDateEmbauche(): ?\DateTime
    {
        return $this->dateEmbauche;
    }

    public function setDateEmbauche(\DateTime $dateEmbauche): static
    {
        $this->dateEmbauche = $dateEmbauche;

        return $this;
    }

    /**
     * @return Collection<int, AffectationPersonnel>
     */
    public function getAffectationPersonnels(): Collection
    {
        return $this->affectationPersonnels;
    }

    public function addAffectationPersonnel(AffectationPersonnel $affectationPersonnel): static
    {
        if (!$this->affectationPersonnels->contains($affectationPersonnel)) {
            $this->affectationPersonnels->add($affectationPersonnel);
            $affectationPersonnel->addPersonnel($this);
        }

        return $this;
    }

    public function removeAffectationPersonnel(AffectationPersonnel $affectationPersonnel): static
    {
        if ($this->affectationPersonnels->removeElement($affectationPersonnel)) {
            $affectationPersonnel->removePersonnel($this);
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
        }

        return $this;
    }

    public function removeVol(Vol $vol): static
    {
        $this->vols->removeElement($vol);

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
        }

        return $this;
    }

    public function removeEntretien(Entretien $entretien): static
    {
        $this->entretiens->removeElement($entretien);

        return $this;
    }
}
