<?php
namespace App\DataPersister;
use App\Entity\Affecter;
use App\Entity\Partenaire;
use App\Repository\UserRepository;
use App\Repository\PartenaireRepository;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Repository\AffecterRepository;

class AffecterPersister implements DataPersisterInterface{
    protected $em;
    protected $repoUser;
    private $repoAffecter;
    public function __construct(EntityManagerInterface $em,AffecterRepository $repoAffecter,
    UserRepository $repoUser){
        $this->em=$em;
        $this->repoUser=$repoUser;
        $this->repoAffecter=$repoAffecter;
    }
    public function supports($data): bool
    {
        return  $data instanceof Affecter;
    }
    public function persist($data)
    {
        $idUser=$data->getUserAffecter()->getId();
        //reuperer les utilisateurs affecter
        $idUserAffecter=$this->repoAffecter->findAffecter();
        $verification=true;
        //verifier si le user est affecter
        foreach ($idUserAffecter as $id){
          if($id['id']===$idUser ){
            $verification=false;
          }
          
        }
       if($verification){
        $this->em->persist($data);
       }

        $this->em->flush();
    }
    public function remove($data)
    {
        $this->em->remove($data);
        $this->em->flush();
    }
    
}