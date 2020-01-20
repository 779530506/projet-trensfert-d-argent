<?php
namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class PostPersister implements DataPersisterInterface{
    protected $em;
    public function __construct(EntityManagerInterface $em){
        $this->em=$em;
    }
    public function supports($data): bool
    {
        return  $data instanceof User;
    }
    public function persist($data)
    {
        $solde=$data->getCompte()->getSolde();
        $data->getCompte()->setSolde($solde+$data->getMontant());
        $this->em->persist($data);
        $this->em->flush();
    }
    public function remove($data)
    {
        $this->em->remove($data);
        $this->em->flush();
    }
}