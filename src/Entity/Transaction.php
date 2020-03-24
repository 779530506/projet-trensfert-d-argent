<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TransactionRepository")
 * @ApiResource(
 *    collectionOperations={
 *         "get"={
 *         "normalization_context"={"groups"={"gets:transaction"}},
 *        },
 *         "post"={
 *           "normalization_context"={"groups"={"post:transaction"}},
 * }
 *     },
 *     itemOperations={
 *         "get"={},
 *         "put"={
 *           },
 *         "delete"={},
 *     }
 * 
 * )
 * 
 * 
 * 
 */
class Transaction
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     * 
     * @Groups("gets:transaction")
     */
    private $dateTrensfert;

    /**
     * @ORM\Column(type="datetime",  nullable=true)
     * @Groups("gets:transaction")
     */
    private $dateRetrait;

    /**
     * @ORM\Column(type="float")
     * @Assert\GreaterThanOrEqual(1000)
     * @Assert\LessThanOrEqual(2000000)
     * @Groups("post:transaction")
     * @Groups("gets:transaction")
     */
    private $montant;

    /**
     * @ORM\Column(type="boolean")
     * @Groups("gets:transaction")
     */
    private $status;

    /**
     * @ORM\Column(type="integer")
     * @Groups("gets:transaction")
     */
    private $code;

    /**
     * @ORM\Column(type="float")
     * @Groups("gets:transaction")
     */
    private $frais;

    /**
     * @ORM\Column(type="string", length=25)
     * @Groups("post:transaction")
     * @Groups("gets:transaction")
     */
    private $nomExpediteur;

    /**
     * @ORM\Column(type="string", length=25)
     * @Groups("post:transaction")
     * @Groups("gets:transaction")
     */
    private $prenomExpediteur;

    /**
     * @ORM\Column(type="string", length=25)
     * @Groups("post:transaction")
     * @Groups("gets:transaction")
     */
    private $telExpediteur;

    /**
     * @ORM\Column(type="string", length=25)
     * @Groups("post:transaction")
     * @Groups("gets:transaction")
     */
    private $cniExpediteur;

    /**
     * @ORM\Column(type="string", length=25)
     * @Groups("post:transaction")
     * @Groups("gets:transaction")
     */
    private $nomBeneficiaire;

    /**
     * @ORM\Column(type="string", length=25)
     * @Groups("post:transaction")
     * @Groups("gets:transaction")
     */
    private $prenomBeneficiaire;

    /**
     * @ORM\Column(type="string", length=25)
     * @Groups("post:transaction")
     * @Groups("gets:transaction")
     */
    private $telBeneficiaire;

    /**
     * @ORM\Column(type="string", length=25, nullable=true)
     * @Groups("gets:transaction")
     */
    private $cniBeneficiaire;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     * @Groups("gets:transaction")
     */
    private $userTrensfert;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @Groups("gets:transaction")
     */
    private $userRetrait;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Compte", inversedBy="transactions")
     * @ORM\JoinColumn(nullable=false)
     * @Groups("post:transaction")
     * @Groups("gets:transaction")
     */
    private $compteTrensfert;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Compte")
     */
    private $compteRetrait;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateTrensfert(): ?\DateTimeInterface
    {
        return $this->dateTrensfert;
    }

    public function setDateTrensfert(\DateTimeInterface $dateTrensfert): self
    {
        $this->dateTrensfert = $dateTrensfert;

        return $this;
    }

    public function getDateRetrait(): ?\DateTimeInterface
    {
        return $this->dateRetrait;
    }

    public function setDateRetrait(\DateTimeInterface $dateRetrait): self
    {
        $this->dateRetrait = $dateRetrait;

        return $this;
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

    public function getStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getCode(): ?int
    {
        return $this->code;
    }

    public function setCode(int $code): self
    {
        $this->code = $code;

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

    public function getNomExpediteur(): ?string
    {
        return $this->nomExpediteur;
    }

    public function setNomExpediteur(string $nomExpediteur): self
    {
        $this->nomExpediteur = $nomExpediteur;

        return $this;
    }

    public function getPrenomExpediteur(): ?string
    {
        return $this->prenomExpediteur;
    }

    public function setPrenomExpediteur(string $prenomExpediteur): self
    {
        $this->prenomExpediteur = $prenomExpediteur;

        return $this;
    }

    public function getTelExpediteur(): ?string
    {
        return $this->telExpediteur;
    }

    public function setTelExpediteur(string $telExpediteur): self
    {
        $this->telExpediteur = $telExpediteur;

        return $this;
    }

    public function getCniExpediteur(): ?string
    {
        return $this->cniExpediteur;
    }

    public function setCniExpediteur(string $cniExpediteur): self
    {
        $this->cniExpediteur = $cniExpediteur;

        return $this;
    }

    public function getNomBeneficiaire(): ?string
    {
        return $this->nomBeneficiaire;
    }

    public function setNomBeneficiaire(string $nomBeneficiaire): self
    {
        $this->nomBeneficiaire = $nomBeneficiaire;

        return $this;
    }

    public function getPrenomBeneficiaire(): ?string
    {
        return $this->prenomBeneficiaire;
    }

    public function setPrenomBeneficiaire(string $prenomBeneficiaire): self
    {
        $this->prenomBeneficiaire = $prenomBeneficiaire;

        return $this;
    }

    public function getTelBeneficiaire(): ?string
    {
        return $this->telBeneficiaire;
    }

    public function setTelBeneficiaire(string $telBeneficiaire): self
    {
        $this->telBeneficiaire = $telBeneficiaire;

        return $this;
    }

    public function getCniBeneficiaire(): ?string
    {
        return $this->cniBeneficiaire;
    }

    public function setCniBeneficiaire(?string $cniBeneficiaire): self
    {
        $this->cniBeneficiaire = $cniBeneficiaire;

        return $this;
    }

    public function getUserTrensfert(): ?User
    {
        return $this->userTrensfert;
    }

    public function setUserTrensfert(?User $userTrensfert): self
    {
        $this->userTrensfert = $userTrensfert;

        return $this;
    }

    public function getUserRetrait(): ?User
    {
        return $this->userRetrait;
    }

    public function setUserRetrait(?User $userRetrait): self
    {
        $this->userRetrait = $userRetrait;

        return $this;
    }

    public function getcompteTrensfert(): ?Compte
    {
        return $this->compteTrensfert;
    }

    public function setcompteTrensfert(?Compte $compteTrensfert): self
    {
        $this->compteTrensfert = $compteTrensfert;

        return $this;
    }

    public function getCompteRetrait(): ?Compte
    {
        return $this->compteRetrait;
    }

    public function setCompteRetrait(?Compte $compteRetrait): self
    {
        $this->compteRetrait = $compteRetrait;

        return $this;
    }
}
