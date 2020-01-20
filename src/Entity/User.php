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
 * @ApiResource()
 *  @ApiFilter(BooleanFilter::class,properties={"isActive"})
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
     * @Groups("admin:post")
     * @Groups("admin:all")
     * @Groups("get:item")
     */
    protected $nom;

     /**
     * @ORM\Column(type="string", length=255)
     * @Groups("admin:post")
     * @Groups("admin:all")
     * @Groups("get:item")
     */
    protected $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("admin:post")
     * @Assert\Email()
     * @Groups("get:item")
     */
    protected $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("admin:post")
     * @Groups("get:item")
     * 
     */
    protected $telephon;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups("admin:post")
     * @Groups("get:item")
     */
    protected $adresse;



    /**
     *    pour la liaison avec la table role
     * @ORM\ManyToOne(targetEntity="App\Entity\Role",cascade={"persist"}, inversedBy="users")
     * @ORM\JoinColumn(nullable=false)
     * @Groups("admin:post")
     * @Groups("admin:all")
     * @Groups("get:item")
     * 
     */
    protected $role;
    /**
   * @ORM\Column(type="json")
     * @Groups("admin:post")
     */
    protected $roles= [];
 

    /**
     * @ORM\Column(type="date")
     * @Groups("admin:post")
     * @Groups("admin:all")
     */
    protected $dateNaissance;

    /**
     * @ORM\Column(type="boolean")
     * @Groups("admin:post")
     * @Groups("admin:all")
     * @Groups("get:item")
     */
    protected $isActive;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("admin:post")
     * @Groups("get:item")
     */
    protected $username;

    /**
   * @ORM\Column(type="string", length=255)
     * @Groups("admin:post")
     */
    protected $password;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Depot", mappedBy="userDepot")
     */
    private $depots;



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
            $depot->setUserDepot($this);
        }

        return $this;
    }

    public function removeDepot(Depot $depot): self
    {
        if ($this->depots->contains($depot)) {
            $this->depots->removeElement($depot);
            // set the owning side to null (unless already changed)
            if ($depot->getUserDepot() === $this) {
                $depot->setUserDepot(null);
            }
        }

        return $this;
    }

   

}