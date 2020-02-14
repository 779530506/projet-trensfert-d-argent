<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PeriodeRepository")
 * @ApiResource()
 */
class Periode
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $dateDebut;

    /**
     * @ORM\Column(type="date")
     */
    private $dateFin;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User")
     */
    private $userAffecter;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Compte")
     */
    private $compteAffecter;

    public function __construct()
    {
        $this->userAffecter = new ArrayCollection();
        $this->compteAffecter = new ArrayCollection();
    }


  

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeInterface $dateDebut): self
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(\DateTimeInterface $dateFin): self
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUserAffecter(): Collection
    {
        return $this->userAffecter;
    }

    public function addUserAffecter(User $userAffecter): self
    {
        if (!$this->userAffecter->contains($userAffecter)) {
            $this->userAffecter[] = $userAffecter;
        }

        return $this;
    }

    public function removeUserAffecter(User $userAffecter): self
    {
        if ($this->userAffecter->contains($userAffecter)) {
            $this->userAffecter->removeElement($userAffecter);
        }

        return $this;
    }

    /**
     * @return Collection|Compte[]
     */
    public function getCompteAffecter(): Collection
    {
        return $this->compteAffecter;
    }

    public function addCompteAffecter(Compte $compteAffecter): self
    {
        if (!$this->compteAffecter->contains($compteAffecter)) {
            $this->compteAffecter[] = $compteAffecter;
        }

        return $this;
    }

    public function removeCompteAffecter(Compte $compteAffecter): self
    {
        if ($this->compteAffecter->contains($compteAffecter)) {
            $this->compteAffecter->removeElement($compteAffecter);
        }

        return $this;
    }


}
