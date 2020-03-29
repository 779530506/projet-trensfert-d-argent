<?php
namespace App\DataPersister;

use App\Entity\User;
use App\Entity\Depot;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Entity\Partenaire;
use App\Osms;
use PhpParser\Node\Stmt\Break_;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class PartenairePersister implements DataPersisterInterface{
    protected $em;
    private $token;
    public function __construct(EntityManagerInterface $em,TokenStorageInterface $token){
        $this->em=$em;
        $this->token=$token;
    }
    public function supports($data): bool
    {
        return  $data instanceof Partenaire ;
    }
    public function persist($data)
    {
       if( $data->getUserPartenaire()->getRoles()[0] !=="ROLE_PARTENAIRE"){
         throw new HttpException(400,"Impossible! un membre du systeme ne peut pas etre un partenaire");
       }
         
  
        $this->em->persist($data);
        $this->em->flush();
    }
    public function remove($data)
    {
        $this->em->remove($data);
        $this->em->flush();
    }
}