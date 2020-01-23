<?php

namespace App\Entity;
use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiFilter;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PartenaireRepository")
 * @ApiResource(
 * attributes={"security"="is_granted('ROLE_ADMIN')"},
 *     collectionOperations={
 *         "get"={"security"="is_granted('ROLE_ADMIN')"},
 *         "post"={"security"="is_granted('ROLE_ADMIN')"}
 *     },
 *     itemOperations={
 *         "get"={"security"="is_granted('ROLE_ADMIN')"},
 *         "put"={"security"="is_granted('ROLE_ADMIN')"},
 *         "delete"={"security"="is_granted('ROLE_ADMIN')"},
 *     }
 * )
 * @ApiFilter(SearchFilter::class,properties={"ninea":"ipartial"})
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

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Compte", mappedBy="partenaire", orphanRemoval=true)
     */
    private $comptes;

    public function __construct()
    {
        parent::__construct();
        $this->comptes = new ArrayCollection();
    }


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

    /**
     * @return Collection|Compte[]
     */
    public function getComptes(): Collection
    {
        return $this->comptes;
    }

    public function addCompte(Compte $compte): self
    {
        if (!$this->comptes->contains($compte)) {
            $this->comptes[] = $compte;
            $compte->setPartenaire($this);
        }

        return $this;
    }

    public function removeCompte(Compte $compte): self
    {
        if ($this->comptes->contains($compte)) {
            $this->comptes->removeElement($compte);
            // set the owning side to null (unless already changed)
            if ($compte->getPartenaire() === $this) {
                $compte->setPartenaire(null);
            }
        }

        return $this;
    }
}
