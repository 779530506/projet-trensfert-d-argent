<?php
namespace App\DataPersister;

use App\Entity\Tarif;
use App\Entity\Transaction;
use App\Repository\UserRepository;
use App\Repository\TarifRepository;
use App\Repository\CompteRepository;
use App\Repository\AffecterRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\TransactionRepository;
use Symfony\Component\HttpKernel\Exception\HttpException;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class TransactionPersister implements DataPersisterInterface{
    protected $em;
    protected $repo;
    private   $token;
    private  $transactionRepository;
    private $userRepository;
    private $compteRepository;
    public function __construct(EntityManagerInterface $em,
    TarifRepository $repo,UserRepository $userRepository,TransactionRepository $transactionRepository,
      TokenStorageInterface $token,CompteRepository $compteRepository){
        $this->em=$em;
        $this->repo=$repo;
        $this->token=$token;
        $this->transactionRepository=$transactionRepository;
        $this->userRepository=$userRepository;
        $this->compteRepository=$compteRepository;
    }
    public function supports($data): bool
    {
        return  $data instanceof Transaction;
    }
    public function persist($data)
    {
        $verifier=true;
        $montant=$data->getMontant();
        $user=$this->token->getToken()->getUser();
        $idCompte=$this->userRepository->getIdCompte($user->getId())["id"];
        $compteAffecter=$this->compteRepository->findOneById($idCompte);
        if($compteAffecter !== null){
            if(!$this->transactionRepository->findOneById($data->getId())){
                $data->setCompteTrensfert($compteAffecter);
                $data->setDateTrensfert(new \DateTime());
                $data->setUserTrensfert($user);
                $data->setFrais($this->repo->findOneByFrais($montant)['frais']);
                //generation du code
                $data->setCode($this->generer());
                $data->setStatus(true);
               while($this->transactionRepository->findOneByCode($data->getCode())){
                  $data->setCode($this->generer()) ;   
                }
                //verification du solde
                $solde=$data->getCompteTrensfert()->getSolde();
                if( $solde - $montant >=0   ){
                  $data->getCompteTrensfert()->setSolde($solde-$montant);
                }else{ $verifier=false; }
             }elseif($data->getCniBeneficiaire() != null && $data->getStatus()===true){
                  $data->setCompteRetrait($compteAffecter);
                  $solde=$data->getCompteRetrait()->getSolde();
                  $soldeInitiale=$data->getCompteRetrait()->getSoldeInitiale();
                  if($soldeInitiale-$solde >= $montant){
                      $data->getCompteRetrait()->setSolde($solde + $montant); 
                      $data->setUserRetrait($user);
                      $data->setDateRetrait(new \DateTime());     
                      $data->setStatus(false);
                     }else{   $verifier=false; }
                   }else{ $verifier=false; }
      
        }else{
            throw new HttpException(400,
                    "vous n'avez pas de compte actif");
        }
      
             //persister
             if($verifier){
                $this->em->persist($data);
                $this->em->flush();
               }else{
                   throw new HttpException(400,
                    "Impossible de faire une transaction;
                     veuillez verifier si votre solde vous permet d'effectuer cette operation");
               }
            
        
    }
    public function remove($data)
    {
        $this->em->remove($data);
        $this->em->flush(); 
    }

    private function generer()
    {
        return rand(0,999999999);
        
    }
}