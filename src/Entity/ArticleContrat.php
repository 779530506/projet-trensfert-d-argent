<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
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
 * 
 * )
 * @ORM\Entity(repositoryClass="App\Repository\ArticleContratRepository")
 */
class ArticleContrat
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
    private $typeArticle;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Contrat", inversedBy="articleContrats")
     */
    private $contrat;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeArticle(): ?string
    {
        return $this->typeArticle;
    }

    public function setTypeArticle(string $typeArticle): self
    {
        $this->typeArticle = $typeArticle;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getContrat(): ?Contrat
    {
        return $this->contrat;
    }

    public function setContrat(?Contrat $contrat): self
    {
        $this->contrat = $contrat;

        return $this;
    }
}
