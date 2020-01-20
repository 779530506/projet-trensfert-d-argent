<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DepotRepository")
 * @ApiResource()
 */
class Depot
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $montant;

    /**
     * @ORM\Column(type="date")
     */
    private $dateDepot;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Compte", inversedBy="depots")
     */
    private $compte;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="depots")
     * @ORM\JoinColumn(nullable=false)
     */
    private $userDepot;


    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMontant(): ?float
    {
        return $this->montant;
    }

    public function setMontant(float $montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    public function getDateDepot(): ?\DateTimeInterface
    {
        return $this->dateDepot;
    }

    public function setDateDepot(\DateTimeInterface $dateDepot): self
    {
        $this->dateDepot = $dateDepot;

        return $this;
    }

    public function getCompte(): ?Compte
    {
        return $this->compte;
    }

    public function setCompte(?Compte $compte): self
    {
        $this->compte = $compte;

        return $this;
    }

    public function getUserDepot(): ?User
    {
        return $this->userDepot;
    }

    public function setUserDepot(?User $userDepot): self
    {
        $this->userDepot = $userDepot;

        return $this;
    }

}
