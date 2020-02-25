<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass="App\Repository\AffecterRepository")
 * @ApiResource()
 */
class Affecter
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\GreaterThanOrEqual("today")
     */
    private $dateDebut;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\GreaterThanOrEqual("today")
     */
    private $dateFin;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Compte", inversedBy="affecters")
     * @ORM\JoinColumn(nullable=false)
     */
    private $compteAffecter;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="affecters")
     * @ORM\JoinColumn(nullable=false)
     */
    private $userAffecter;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $userQuiAffecte;

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

    public function getCompteAffecter(): ?Compte
    {
        return $this->compteAffecter;
    }

    public function setCompteAffecter(?Compte $compteAffecter): self
    {
        $this->compteAffecter = $compteAffecter;

        return $this;
    }

    public function getUserAffecter(): ?User
    {
        return $this->userAffecter;
    }

    public function setUserAffecter(?User $userAffecter): self
    {
        $this->userAffecter = $userAffecter;

        return $this;
    }

    public function getUserQuiAffecte(): ?User
    {
        return $this->userQuiAffecte;
    }

    public function setUserQuiAffecte(?User $userQuiAffecte): self
    {
        $this->userQuiAffecte = $userQuiAffecte;

        return $this;
    }

   
}
