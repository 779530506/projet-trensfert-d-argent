<?php
namespace App\DataPersister;

use App\Entity\User;
use App\Entity\Depot;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class DepotPersister implements DataPersisterInterface{
    protected $em;
    private $token;
    public function __construct(EntityManagerInterface $em,TokenStorageInterface $token){
        $this->em=$em;
        $this->token=$token;
    }
    public function supports($data): bool
    {
        return  $data instanceof Depot ;
    }
    public function persist($data)
    {
        $data->getCompte()->setSolde($data->getCompte()->getSolde()+$data->getMontant());
        $data->setDateDepot(new \DateTime());
        $data->setUserDepot($this->token->getToken()->getUser());
        $this->em->persist($data);
        $this->em->flush();
    }
    public function remove($data)
    {
        $this->em->remove($data);
        $this->em->flush();
    }
}