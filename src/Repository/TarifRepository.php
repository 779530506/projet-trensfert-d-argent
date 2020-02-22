<?php

namespace App\Repository;

use App\Entity\Tarif;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Tarif|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tarif|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tarif[]    findAll()
 * @method Tarif[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TarifRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tarif::class);
    }
  
  /**
   * recuperer le frais
   *
   * @param [type] $montant
   * 
   */
    public function findOneByFrais($montant)
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = ' SELECT frais FROM tarif as t WHERE t.montant_debut<=:montant 
        AND t.montant_fin >= :montant';
        $stmt = $conn->prepare($sql);
        $stmt->execute(
            array(
                'montant'=>$montant
            )
        );
        return $stmt->fetch();
    }

 
    // /**
    //  * @return Tarif[] Returns an array of Tarif objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Tarif
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
