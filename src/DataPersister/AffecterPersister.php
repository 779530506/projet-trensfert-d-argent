<?php
namespace App\DataPersister;
use App\Entity\Affecter;
use App\Entity\Partenaire;
use App\Repository\UserRepository;
use App\Repository\AffecterRepository;
use App\Repository\PartenaireRepository;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class AffecterPersister implements DataPersisterInterface{
    protected $em;
    protected $repoUser;
    private $repoAffecter;
    private $token;
    public function __construct(EntityManagerInterface $em,
    AffecterRepository $repoAffecter,
    UserRepository $repoUser, TokenStorageInterface $token ){
        $this->em=$em;
        $this->repoUser=$repoUser;
        $this->repoAffecter=$repoAffecter;
        $this->token=$token;
    }
    public function supports($data): bool
    {
        return  $data instanceof Affecter;
    }
    public function persist($data)
    {   //recuperer  user qui affecte
        $userQuiAffecte=$data->getUserQuiAffecte();
         //recuperer  user  affecter
         $userAffecter=$data->getUserAffecter();
        // recuperer le compte
        $compte=$data->getCompteAffecter();
        
        //verifier si l'utilisateur n'a pas un compte affecter affecter
        $nbrCompteAffecter=$this->repoAffecter->findAffecter($userAffecter->getId());

        if($userQuiAffecte == null || $compte ==null || $userAffecter==null){
            throw new  HttpException(400,"vous n'etes pas autoriser ");
        }

       if($nbrCompteAffecter == 0 ){  
           if($userQuiAffecte->getPartenaire()!==null){
            if($userQuiAffecte->getPartenaire()->getId() ===$compte->getPartenaire()->getId()){
                $data->setUserQuiAffecte($this->token->getToken()->getUser());   
                $this->em->persist($data);
               } else{
                throw new HttpException(400,"Ce compte ne vous appartient pas");
               }
           }else{
            throw new HttpException(400,"vous n'avez pas de partenaire");
        }
       }else{
           throw new HttpException(400,"vous avez déjà un compte");
       }

        $this->em->flush();
    }
    public function remove($data)
    {
        $this->em->remove($data);
        $this->em->flush();
    }
    
}