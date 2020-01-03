<?php
namespace App\Entity;

use ApiPlatform\Core\Api\FilterInterface;

class RoleFilter implements FilterInterface {
     private $role;
     private $nom;

     public function getDescription(string $resourceClass): array
     {
         
     }

     /**
      * Get the value of role
      */ 
     public function getRole()
     {
          return $this->role;
     }

     /**
      * Set the value of role
      *
      * @return  self
      */ 
     public function setRole($role)
     {
          $this->role = $role;

          return $this;
     }

     /**
      * Get the value of nom
      */ 
     public function getNom()
     {
          return $this->nom;
     }

     /**
      * Set the value of nom
      *
      * @return  self
      */ 
     public function setNom($nom)
     {
          $this->nom = $nom;

          return $this;
     }
}