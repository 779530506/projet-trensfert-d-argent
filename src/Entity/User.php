<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\InheritanceType;
use ApiPlatform\Core\Annotation\ApiFilter;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\Unique;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 *  @UniqueEntity(
 *   fields={"username"}
 *   )
 * @ApiResource(
 * attributes={"security"="is_granted('ROLE_ADMIN')"},
 *     collectionOperations={
 *     "get"={
 *               "security"="is_granted('ROLE_ADMIN')",
 *                "normalization_context"={"groups"={"get:all"}},
 *              }, 
 *          "post"={
 *            "security"="is_granted('ROLE_ADMIN')",
 *            "normalization_context"={"groups"={"post:all"}},
 *   }
 *     },
 *     itemOperations={
 *         "get"={
 *           "security"="is_granted('ROLE_ADMIN')",
 *            "normalization_context"={"groups"={"get:one"}},
 *        },
 *         "put"={
 *        "security"="is_granted('ROLE_ADMIN')",
 *        "normalization_context"={"groups"={"put:one"}},
 *      },
 *         "delete"={"security"="is_granted('ROLE_ADMIN')"},
 *     }
 * )
 * @ApiFilter(BooleanFilter::class,properties={"isActive"})
 * @ApiFilter(SearchFilter::class,properties={"role.libelle":"iexact"})
 * @ORM\InheritanceType("JOINED")
 */
    class User implements AdvancedUserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("get:all")
     * @Groups("post:all")
     * @Groups("get:one")
     * @Groups("put:one")
     */
    protected $nom;

     /**
     * @ORM\Column(type="string", length=255)
     * @Groups("get:all")
     * @Groups("post:all")
     *  @Groups("get:one")
     * @Groups("put:one")
     */
    protected $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Email()
     * @Groups("get:all")
     * @Groups("post:all")
     * @Groups("put:one")
     * @Groups("get:one")
     * 
     */
    protected $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("get:all") 
     * @Groups("post:all")
     * @Groups("get:one") 
     * @Groups("put:one")
     */
    protected $telephon;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *  @Groups("get:all")
     *  @Groups("post:all")
     *  @Groups("get:one")
     *  @Groups("put:one")
     */
    protected $adresse;



    /**
     *    pour la liaison avec la table role
     * @ORM\ManyToOne(targetEntity="App\Entity\Role",cascade={"persist"}, inversedBy="users")
     *  @Groups("get:all")
     *  @Groups("post:all")
     *  @Groups("get:one")
     *  @Groups("put:one")
     */
    protected $role;
    /**
     * @ORM\Column(type="json")
     *  @Groups("get:all")
     *  @Groups("post:all")
     *  @Groups("get:one")
     * @Groups("put:one")
     */
    protected $roles= [];
 

    /**
     * @ORM\Column(type="date")
     * @Groups("post:all")
     * @Groups("get:all")
     *  @Groups("get:one")
     * @Groups("put:one")
     */
    protected $dateNaissance;

    /**
     * @ORM\Column(type="boolean")
     * @Groups("post:all")
     * @Groups("get:all")
     *  @Groups("get:one")
     *  @Groups("put:one")
     */
    protected $isActive;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("get:all")
     * @Groups("post:all")
     *  @Groups("get:one")
     * @Groups("put:one")
     */
    protected $username;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("get:all")
     * @Groups("post:all")
     *  @Groups("get:one")
     * @Groups("put:one")
     */
    protected $password;


    //le constructeur
    public function __construct(){
        $this->isActive=false;
        $this->depots = new ArrayCollection();

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
   
      /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
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

    public function getisActive(): ?bool
    {
        return $this->isActive;
    }

    public function setisActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get the value of adresse
     */ 
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * Set the value of adresse
     *
     * @return  self
     */ 
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function isAccountNonExpired()
    {
        return true;
    }

    public function isAccountNonLocked()
    {
        return true;
    }

    public function isCredentialsNonExpired()
    {
        return true;
    }


    public function isEnabled()
    {
        return $this->isActive;
    }

  
}