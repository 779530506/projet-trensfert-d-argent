<?php
namespace App\DataPersister;

use App\Entity\User;
use App\Entity\Depot;
use PhpParser\Node\Stmt\Break_;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class UserPersister implements DataPersisterInterface{
    protected $em;
    private $token;
    private $encode;
    public function __construct(UserPasswordEncoderInterface $encode,
        EntityManagerInterface $em,TokenStorageInterface $token){
        $this->em=$em;
        $this->token=$token;
        $this->encode=$encode;   
    }
    public function supports($data): bool
    {
        return  $data instanceof User ;
    }
    public function persist($data)
    {
        $roles=$data->getRole()->getLibelle();
         $data->setRoles(["ROLE_".$roles]);
         $data->setUserCreate($this->token->getToken()->getUser());
         $data->setPassword($this->encode->encodePassword($data,$data->getPassword()));
         if($data->getIsActive()!== true){
            $data->setIsActive=false;
         }
       if($data->getPartenaire()!= null && $roles!=="ADMINPARTENAIRE" &&
            $roles !== "USERPARTENAIRE" ){
                throw new HttpException(400,"impossible de lui relier à un partenaire");   
       }
        $role=$this->token->getToken()->getRoles()[0]->getRole();
       if("ROLE_PARTENAIRE"===$role){
           $data->setPartenaire($this->token->getToken()->getUser());
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