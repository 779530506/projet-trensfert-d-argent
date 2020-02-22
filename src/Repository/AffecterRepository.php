<?php

namespace App\Repository;

use App\Entity\Affecter;
use App\Entity\Compte;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Periode|null find($id, $lockMode = null, $lockVersion = null)
 * @method Periode|null findOneBy(array $criteria, array $orderBy = null)
 * @method Periode[]    findAll()
 * @method Periode[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AffecterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Affecter::class);
    }
    /**
     * Undocumented function
     *
     * @return array|null
     */
    public function findAffecter():?array
    {
        $dateActuelle=new \DateTime() ;
        return $this->createQueryBuilder('a')
        ->select('u.id')
        ->join('a.userAffecter','u')
        ->andWhere('a.dateDebut < :dateActuelle')
        ->andWhere('a.dateFin > :dateActuelle')
        ->setParameters(array(
                           'dateActuelle' =>  $dateActuelle))
        ->getQuery()
        ->getResult()
    ;
    }
   
   
    // /**
    //  * @return Periode[] Returns an array of Periode objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Periode
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
