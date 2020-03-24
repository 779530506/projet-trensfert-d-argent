<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TarifRepository")
 * @ApiResource()
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
     * @ORM\Column(type="float")
     */
    private $montantDebut;

    /**
     * @ORM\Column(type="float")
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

   
    public function getFrais(): ?float
    {
        return $this->frais;
    }

    public function setFrais(float $frais): self
    {
        $this->frais = $frais;

        return $this;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of montantDebut
     */ 
    public function getMontantDebut()
    {
        return $this->montantDebut;
    }

    /**
     * Set the value of montantDebut
     *
     * @return  self
     */ 
    public function setMontantDebut($montantDebut)
    {
        $this->montantDebut = $montantDebut;

        return $this;
    }

    /**
     * Get the value of montantFin
     */ 
    public function getMontantFin()
    {
        return $this->montantFin;
    }

    /**
     * Set the value of montantFin
     *
     * @return  self
     */ 
    public function setMontantFin($montantFin)
    {
        $this->montantFin = $montantFin;

        return $this;
    }
}
