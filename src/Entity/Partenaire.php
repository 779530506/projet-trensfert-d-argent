<?php

namespace App\Entity;
use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PartenaireRepository")
 * @ApiResource()
 */
class Partenaire extends User
{


    /**
     * @ORM\Column(type="string", length=10)
     */
    protected $ninea;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $registreDuCommerce;


    public function getNinea(): ?string
    {
        return $this->ninea;
    }

    public function setNinea(string $ninea): self
    {
        $this->ninea = $ninea;

        return $this;
    }

    public function getRegistreDuCommerce(): ?string
    {
        return $this->registreDuCommerce;
    }

    public function setRegistreDuCommerce(string $registreDuCommerce): self
    {
        $this->registreDuCommerce = $registreDuCommerce;

         return $this;
    }
}
