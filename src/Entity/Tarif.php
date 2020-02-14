<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TarifRepository")
 */
class Tarif
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
    private $montantDebut;

    /**
     * @ORM\Column(type="date")
     */
    private $montantFin;

    /**
     * @ORM\Column(type="float")
     */
    private $frais;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMontantDebut(): ?\DateTimeInterface
    {
        return $this->montantDebut;
    }

    public function setMontantDebut(\DateTimeInterface $montantDebut): self
    {
        $this->montantDebut = $montantDebut;

        return $this;
    }

    public function getMontantFin(): ?\DateTimeInterface
    {
        return $this->montantFin;
    }

    public function setMontantFin(\DateTimeInterface $montantFin): self
    {
        $this->montantFin = $montantFin;

        return $this;
    }

    public function getFrais(): ?float
    {
        return $this->frais;
    }

    public function setFrais(float $frais): self
    {
        $this->frais = $frais;

        return $this;
    }
}
