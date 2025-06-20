<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Model\Enum\RolePersonnelEnum;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use App\Repository\AffectationPersonnelRepository;

#[ORM\Entity(repositoryClass: AffectationPersonnelRepository::class)]
class AffectationPersonnel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, Personnel>
     */
    #[ORM\ManyToMany(targetEntity: Personnel::class, inversedBy: 'affectationPersonnels')]
    private Collection $personnel;

    #[ORM\Column(enumType: RolePersonnelEnum::class)]
    private ?RolePersonnelEnum $roleVol = null;

    public function __construct()
    {
        $this->personnel = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Personnel>
     */
    public function getPersonnel(): Collection
    {
        return $this->personnel;
    }

    public function addPersonnel(Personnel $personnel): static
    {
        if (!$this->personnel->contains($personnel)) {
            $this->personnel->add($personnel);
        }

        return $this;
    }

    public function removePersonnel(Personnel $personnel): static
    {
        $this->personnel->removeElement($personnel);

        return $this;
    }

    public function getRoleVol(): ?RolePersonnelEnum
    {
        return $this->roleVol;
    }

    public function setRoleVol(RolePersonnelEnum $roleVol): static
    {
        $this->roleVol = $roleVol;

        return $this;
    }
}
