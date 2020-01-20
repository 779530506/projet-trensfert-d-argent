<?php
namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Entity\Compte;
use App\Repository\CompteRepository;
use Doctrine\ORM\EntityManagerInterface;

class ComptePersister implements DataPersisterInterface{
    protected $em;
    protected $repo;
    public function __construct(EntityManagerInterface $em,CompteRepository $repo){
        $this->em=$em;
        $this->repo=$repo;
    }
    public function supports($data): bool
    {
        return  $data instanceof Compte;
    }
    public function persist($data)
    {
        $lastCompte=$this->repo->getLastCompte();
        $lastId=$lastCompte['id'];
        $data->setNumeroCompte(sprintf("NCP-%05d",$lastId));
        $data->setCreatedDate(new \DateTime());
        $this->em->persist($data);
        $this->em->flush();
    }
    public function remove($data)
    {
        $this->em->remove($data);
        $this->em->flush();
    }
}