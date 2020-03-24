<?php

namespace App\Repository;

use App\Entity\Compte;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }
   /**
    * recuperer le user affecter a une periode valide
    *
    * @param [type] $id
    * @return Compte|null
    */
    public function getIdCompte($id)
    {
        $dateActuelle=new \DateTime() ;
        return $this->createQueryBuilder('u')
        ->select('c.id')
        ->andWhere('u.id = :id')
        ->andWhere(':dateActuelle BETWEEN a.dateDebut AND a.dateFin')
        ->join('u.affecters', 'a')
        ->join('a.compteAffecter','c')
        ->setParameters(array(
                           'id'=>$id,
                           'dateActuelle' =>  $dateActuelle))
        ->getQuery()
        ->getOneOrNullResult()
    ;
    }

    // /**
    //  * @return User[] Returns an array of User objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
