<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\Unique;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 *  @UniqueEntity(
 *   fields={"username"}
 *   )
 * @ApiResource(
 *     collectionOperations={
 *         "get"={"normalization_context"={"groups"={"admin:all"}},} , 
 *         "post"={
 *                "security"="is_granted('ROLE_ADMIN')",
 *                "denormalization_context"={"groups"={"admin:post"}}, 
 *               }
 *     },
 *     itemOperations={
 *         "get",
 *         "put"={
 *           "security"="is_granted('ROLE_ADMIN')",
 *           "denormalization_context"={"groups"={"admin:input"}}}
 *     }
 * 
 * )
 *  @ApiFilter(BooleanFilter::class,properties={"isActif"})
 * @ApiFilter(SearchFilter::class,properties={"role.libelle":"iexact"})
 */
    class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("admin:post")
     * @Groups("admin:all")
     */
    private $nom;

     /**
     * @ORM\Column(type="string", length=255)
     * @Groups("admin:post")
     * @Groups("admin:all")
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("admin:post")
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("admin:post")
     * 
     */
    private $telephon;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("admin:post")
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("admin:post")
     */
    private $password;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Role",cascade={"persist"}, inversedBy="users")
     * @ORM\JoinColumn(nullable=false)
     * @Groups("admin:post")
     * @Groups("admin:all")
     * 
     */
    private $role;

 

    /**
     * @ORM\Column(type="date")
     * @Groups("admin:post")
     * @Groups("admin:all")
     */
    private $dateNaissance;

    /**
     * @ORM\Column(type="boolean")
     * @Groups("admin:post")
     * @Groups("admin:all")//pour l'affichage generale
     */
    private $isActif;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $adresse;

    //le constructeur
    public function __construc(){
        $this->isActif=false;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getTelephon(): ?string
    {
        return $this->telephon;
    }

    public function setTelephon(string $telephon): self
    {
        $this->telephon = $telephon;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getRole(): ?Role
    {
        return $this->role;
    }

    public function setRole(?Role $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }
    //les fonction redefinis 
    public function getRoles(){
        if($this->role->getLibelle()=="adminSystem"){
        return array('ROLE_SUPADMIN');
        }elseif($this->role->getLibelle()=="admin"){
            return array('ROLE_ADMIN');
            }elseif($this->role->getLibelle()=="caissier"){
                return array('ROLE_CAISSIER');
                }
    }
    public function getSalt(){}
    public function eraseCredentials(){}

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(\DateTimeInterface $dateNaissance): self
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    public function getIsActif(): ?bool
    {
        return $this->isActif;
    }

    public function setIsActif(bool $isActif): self
    {
        $this->isActif = $isActif;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }
}