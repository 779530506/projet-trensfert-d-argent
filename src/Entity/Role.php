<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiFilter;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RoleRepository")
 * @ApiResource(
 * attributes={
 *      
 *     "security"="is_granted('ROLE_ADMIN')"},
 *       collectionOperations={
 *         "get"={"security"="is_granted('ROLE_ADMIN')",
 *                "normalization_context"={"groups"={"read"}},
 *               },
 *      },
 *     itemOperations={
 *      "get"={},
 *
 *  },
 * )
 * @ApiFilter(SearchFilter::class,properties={"libelle":"iexact"})
 */
class Role
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("read")
     * @Groups("admin:all")
     */
    private $libelle;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\User", mappedBy="role")
     * @ApiSubresource(maxDepth=1)
     */
    private $users;


    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->partenaires = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setRole($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            // set the owning side to null (unless already changed)
            if ($user->getRole() === $this) {
                $user->setRole(null);
            }
        }

        return $this;
    }


}
