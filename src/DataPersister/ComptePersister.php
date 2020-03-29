<?php
namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Entity\Compte;
use App\Entity\Depot;
use App\Repository\CompteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class ComptePersister implements DataPersisterInterface{
    protected $em;
    protected $repo;
    private   $token;
    public function __construct(EntityManagerInterface $em,
    CompteRepository $repo,TokenStorageInterface $token){
        $this->em=$em;
        $this->repo=$repo;
        $this->token=$token;
    }
    public function supports($data): bool
    {
        return  $data instanceof Compte;
    }
    public function persist($data)
    {

        $data->setSoldeInitiale($data->getSolde());
        $lastCompte=$this->repo->getLastCompte();
        $lastId=$lastCompte['id']+1;
        $data->setNumeroCompte(sprintf("NCP-%05d",$lastId));
        $data->setCreatedDate(new \DateTime());
        $data->setUserCreateur($this->token->getToken()->getUser());
        $this->em->persist($data);
        $this->em->flush();
    }
    public function remove($data)
    {
        $this->em->remove($data);
        $this->em->flush();
    }
}