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
 *     collectionOperations={
 *     "get"={
 *                "normalization_context"={"groups"={"get:all"}},
 *              }, 
 *          "post"={
 *            "normalization_context"={"groups"={"post:all"}},
 *            "access_controle"="is_granted('POST',object)"
 *   }
 *     },
 *     itemOperations={
 *         "get"={
 *            "normalization_context"={"groups"={"get:one"}},
 *        },
 *         "put"={
 *        "normalization_context"={"groups"={"put:one"}},
 *      },
 *         "delete"={},
 *     }
 * )
 * @ApiFilter(BooleanFilter::class,properties={"isActive"})
 * @ApiFilter(SearchFilter::class,properties={"role.libelle":"iexact"})
 */
    class User implements AdvancedUserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups("post:all")
     * @Groups("get:all")
     * @Groups("get:one")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=55, nullable=false)
     * @Groups("get:all")
     * @Groups("post:all")
     * @Groups("get:one")
     * @Groups("put:one")
     * @Groups("get:all-compte")
     */
    protected $nom;

     /**
     * @ORM\Column(type="string", length=55, nullable=false)
     * @Groups("get:all")
     * @Groups("post:all")
     *  @Groups("get:one")
     * @Groups("put:one")
     * @Groups("get:all-compte")
     */
    protected $prenom;

    /**
     * @ORM\Column(type="string", length=100, nullable=false)
     * @Assert\Email()
     * @Groups("get:all")
     * @Groups("post:all")
     * @Groups("put:one")
     * @Groups("get:one")
     * @Groups("get:all-compte")
     */
    protected $email;

    /**
     * @ORM\Column(type="string", length=25, nullable=false)
     * @Groups("get:all") 
     * @Groups("post:all")
     * @Groups("get:one") 
     * @Groups("put:one")
     * @Groups("get:all-compte")
     */
    protected $telephon;


    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     *  @Groups("get:all")
     *  @Groups("post:all")
     *  @Groups("get:one")
     *  @Groups("put:one")
     */
    protected $adresse;



    /**
     *    pour la liaison avec la table role
     * @ORM\ManyToOne(targetEntity="App\Entity\Role",cascade={"persist"}, inversedBy="users")
     * 
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
     * @ORM\Column(type="date", nullable=false)
     * @Groups("post:all")
     * @Groups("get:all")
     * @Groups("get:one")
     * @Groups("put:one")
     */
    protected $dateNaissance;

    /**
     * @ORM\Column(type="boolean", nullable=false)
     * @Groups("post:all")
     * @Groups("get:all")
     * @Groups("get:one")
     * @Groups("put:one")
     */
    protected $isActive;

    /**
     * @ORM\Column(type="string", length=155)
     * @Groups("get:all")
     * @Groups("post:all")
     * @Groups("get:one")
     * @Groups("put:one")
     * @Groups("get:all-compte")
     */
    protected $username;

    /**
     * @ORM\Column(type="string")
     * @Groups("post:all")
     * @Groups("put:one")
     */
    protected $password;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Partenaire", inversedBy="users")
     * 
     */
    private $partenaire;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Affecter", mappedBy="userAffecter", orphanRemoval=true)
     */
    private $affecters;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="users")
     */
    private $userCreate;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\User", mappedBy="userCreate", orphanRemoval=true)
     * 
     */
    private $users;

   

    //le constructeur
    public function __construct(){
        $this->isActive=false;
        $this->depots = new ArrayCollection();
        $this->affecters = new ArrayCollection();
        $this->users = new ArrayCollection();

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

    public function getPartenaire(): ?Partenaire
    {
        return $this->partenaire;
    }

    public function setPartenaire(?Partenaire $partenaire): self
    {
        $this->partenaire = $partenaire;

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
            $affecter->setUserAffecter($this);
        }

        return $this;
    }

    public function removeAffecter(Affecter $affecter): self
    {
        if ($this->affecters->contains($affecter)) {
            $this->affecters->removeElement($affecter);
            // set the owning side to null (unless already changed)
            if ($affecter->getUserAffecter() === $this) {
                $affecter->setUserAffecter(null);
            }
        }

        return $this;
    }

    public function getUserCreate(): ?self
    {
        return $this->userCreate;
    }

    public function setUserCreate(?self $userCreate): self
    {
        $this->userCreate = $userCreate;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(self $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setUserCreate($this);
        }

        return $this;
    }

    public function removeUser(self $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            // set the owning side to null (unless already changed)
            if ($user->getUserCreate() === $this) {
                $user->setUserCreate(null);
            }
        }

        return $this;
    }

  
}