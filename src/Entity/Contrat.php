<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource(
 *  attributes={"security"="is_granted('ROLE_ADMIN')"},
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
 * @ORM\Entity(repositoryClass="App\Repository\ContratRepository")
 */
class Contrat
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $numeroContrat;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ArticleContrat", mappedBy="contrat")
     */
    private $articleContrats;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Compte", mappedBy="contrat")
     */
    private $comptes;

    public function __construct()
    {
        $this->articleContrats = new ArrayCollection();
        $this->comptes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumeroContrat(): ?string
    {
        return $this->numeroContrat;
    }

    public function setNumeroContrat(string $numeroContrat): self
    {
        $this->numeroContrat = $numeroContrat;

        return $this;
    }

    /**
     * @return Collection|ArticleContrat[]
     */
    public function getArticleContrats(): Collection
    {
        return $this->articleContrats;
    }

    public function addArticleContrat(ArticleContrat $articleContrat): self
    {
        if (!$this->articleContrats->contains($articleContrat)) {
            $this->articleContrats[] = $articleContrat;
            $articleContrat->setContrat($this);
        }

        return $this;
    }

    public function removeArticleContrat(ArticleContrat $articleContrat): self
    {
        if ($this->articleContrats->contains($articleContrat)) {
            $this->articleContrats->removeElement($articleContrat);
            // set the owning side to null (unless already changed)
            if ($articleContrat->getContrat() === $this) {
                $articleContrat->setContrat(null);
            }
        }

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
            $compte->setContrat($this);
        }

        return $this;
    }

    public function removeCompte(Compte $compte): self
    {
        if ($this->comptes->contains($compte)) {
            $this->comptes->removeElement($compte);
            // set the owning side to null (unless already changed)
            if ($compte->getContrat() === $this) {
                $compte->setContrat(null);
            }
        }

        return $this;
    }
}
