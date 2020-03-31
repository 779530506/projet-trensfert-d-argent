<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiFilter;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CompteRepository")
 * @ApiResource(
 *     collectionOperations={
 *         "get"={
 *         "normalization_context"={"groups"={"get:all-compte"}},
 *        },
 *         "post"={}
 *     },
 *     itemOperations={
 *         "get"={},
 *         "put"={},
 *         "delete"={},
 *     }
 * )
 * @ApiFilter(SearchFilter::class,properties={"numeroCompte":"partial"})
 * @ApiFilter(SearchFilter::class,properties={"numeroCompte":"exact"})
 */
class Compte
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=9, unique=true)
     * @Groups("get:all-compte")
     */
    private $numeroCompte;

    /**
     * @ORM\Column(type="float")
     * @Assert\GreaterThanOrEqual(
     *     value = 500000
     * )
     * @Groups("get:all-compte")
     */
    private $solde;

    /**
     * @ORM\Column(type="date")
     * @Groups("get:all-compte")
     */
    private $createdDate;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Depot", mappedBy="compte")
     */
    private $depots;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     *
     */
    private $userCreateur;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Transaction", mappedBy="compte", orphanRemoval=true)
     */
    private $transactions;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Partenaire", inversedBy="comptes")
     * @ORM\JoinColumn(nullable=false)
     * @Groups("get:all-compte")
     */
    private $partenaire;

    /**
     * @ORM\Column(type="float")
     * @Groups("get:all")
     */
    private $soldeInitiale;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Affecter", mappedBy="compteAffecter", orphanRemoval=true)
     */
    private $affecters;



    public function __construct()
    {
        $this->depots = new ArrayCollection();
        $this->transactions = new ArrayCollection();
        $this->periodes = new ArrayCollection();
        $this->affecters = new ArrayCollection();
    }




    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumeroCompte(): ?string
    {
        return $this->numeroCompte;
    }

    public function setNumeroCompte(string $numeroCompte): self
    {
        $this->numeroCompte = $numeroCompte;

        return $this;
    }

    public function getSolde(): ?float
    {
        return $this->solde;
    }

    public function setSolde(float $solde): self
    {
        $this->solde = $solde;

        return $this;
    }

    public function getCreatedDate(): ?\DateTimeInterface
    {
        return $this->createdDate;
    }

    public function setCreatedDate(\DateTimeInterface $createdDate): self
    {
        $this->createdDate = $createdDate;

        return $this;
    }


    /**
     * @return Collection|Depot[]
     */
    public function getDepots(): Collection
    {
        return $this->depots;
    }

    public function addDepot(Depot $depot): self
    {
        if (!$this->depots->contains($depot)) {
            $this->depots[] = $depot;
            $depot->setCompte($this);
        }

        return $this;
    }

    public function removeDepot(Depot $depot): self
    {
        if ($this->depots->contains($depot)) {
            $this->depots->removeElement($depot);
            // set the owning side to null (unless already changed)
            if ($depot->getCompte() === $this) {
                $depot->setCompte(null);
            }
        }

        return $this;
    }

    public function getUserCreateur(): ?User
    {
        return $this->userCreateur;
    }

    public function setUserCreateur(?User $userCreateur): self
    {
        $this->userCreateur = $userCreateur;

        return $this;
    }

    /**
     * @return Collection|Transaction[]
     */
    public function getTransactions(): Collection
    {
        return $this->transactions;
    }

    public function addTransaction(Transaction $transaction): self
    {
        if (!$this->transactions->contains($transaction)) {
            $this->transactions[] = $transaction;
            $transaction->setCompteTrensfert($this);
        }

        return $this;
    }

    public function removeTransaction(Transaction $transaction): self
    {
        if ($this->transactions->contains($transaction)) {
            $this->transactions->removeElement($transaction);
            // set the owning side to null (unless already changed)
            if ($transaction->getCompteTrensfert() === $this) {
                $transaction->setCompteTrensfert(null);
            }
        }

        return $this;
    }

    public function getPartenaire(): ?Partenaire
    {
        return $this->partenaire;
    }

    public function setPartenaire(?Partenaire $partenaire): self
    {
        $this->partenaire = $partenaire;

        return $this;
    }

    public function getSoldeInitiale(): ?float
    {
        return $this->soldeInitiale;
    }

    public function setSoldeInitiale(float $soldeInitiale): self
    {
        $this->soldeInitiale = $soldeInitiale;

        return $this;
    }

    /**
     * @return Collection|Affecter[]
     */
    public function getAffecters(): Collection
    {
        return $this->affecters;
    }

    public function addAffecter(Affecter $affecter): self
    {
        if (!$this->affecters->contains($affecter)) {
            $this->affecters[] = $affecter;
            $affecter->setCompteAffecter($this);
        }

        return $this;
    }

    public function removeAffecter(Affecter $affecter): self
    {
        if ($this->affecters->contains($affecter)) {
            $this->affecters->removeElement($affecter);
            // set the owning side to null (unless already changed)
            if ($affecter->getCompteAffecter() === $this) {
                $affecter->setCompteAffecter(null);
            }
        }

        return $this;
    }


}
