<?php
namespace App\DataPersister;

use App\Entity\User;
use App\Entity\Depot;
use PhpParser\Node\Stmt\Break_;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Repository\PartenaireRepository;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class UserPersister implements DataPersisterInterface{
    protected $em;
    private $token;
    private $encode;
    private $partenaireRepository;
    public function __construct(UserPasswordEncoderInterface $encode,
        EntityManagerInterface $em,TokenStorageInterface $token, PartenaireRepository $partenaireRepository){
        $this->em=$em;
        $this->token=$token;
        $this->encode=$encode;   
        $this->partenaireRepository= $partenaireRepository;
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
         $role=$this->token->getToken()->getRoles()[0]->getRole();
         // gestion d'autorisation 
         if("ROLE_PARTENAIRE"===$role){
           $idPartenaire = $this->token->getToken()->getUser()->getId();
           $partenaire = $this->partenaireRepository->findByIdUser($idPartenaire);
           $data->setPartenaire($partenaire[0]);
           if($roles!=="ADMINPARTENAIRE" && $roles !== "USERPARTENAIRE" ){
               throw new HttpException(401,"Erreur!  un ". $role. " pouvez pas créer un user de type ".$roles);   
            }
        }elseif("ROLE_SUPADMIN"===$role){
            if($roles!=="ADMIN" && $roles !== "CAISSIER" ){
                throw new HttpException(401,"Erreur!  un ". $role. " ne peut pas créer un user de type ".$roles);   
             }
        }elseif("ROLE_ADMIN"===$role){
            if($roles !== "CAISSIER" && $roles !== "PARTENAIRE"){
                throw new HttpException(401,"Erreur!  un ". $role. "  ne peut pas créer un user de type ".$roles);   
             }
        }elseif("ROLE_ADMINPARTENAIRE"===$role){
           $idPartenaire = $this->token->getToken()->getUser()->getUserCreate()->getId();
           $partenaire = $this->partenaireRepository->findByIdUser($idPartenaire);
           $data->setPartenaire($partenaire[0]);
            if($roles !== "USERPARTENAIRE"){
                throw new HttpException(401,"Erreur! un ". $role. " ne peut pas créer un user de type ".$roles);   
             }
        }else{
           throw new HttpException(401,"Erreur! vous ne pouvez pas créer un user de type ".$roles);   
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