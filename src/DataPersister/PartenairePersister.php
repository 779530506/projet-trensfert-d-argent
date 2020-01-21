<?php
namespace App\DataPersister;
use App\Entity\Partenaire;
use App\Repository\PartenaireRepository;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;

class PartenairePersister implements DataPersisterInterface{
    protected $em;
    protected $repo;
    public function __construct(EntityManagerInterface $em,PartenaireRepository $repo){
        $this->em=$em;
        $this->repo=$repo;
    }
    public function supports($data): bool
    {
        return  $data instanceof Partenaire;
    }
    public function persist($data)
    {
        $lastPartenaire=$this->repo->getLastPartenaire();
        $lastId=$lastPartenaire['id']+1;
        $data->setNinea(sprintf("NIN-%05d",$lastId));
        $data->setRegistreDuCommerce(sprintf("RC-%05d",$lastId));
        $this->em->persist($data);
        $this->em->flush();
    }
    public function remove($data)
    {
        $this->em->remove($data);
        $this->em->flush();
    }
}