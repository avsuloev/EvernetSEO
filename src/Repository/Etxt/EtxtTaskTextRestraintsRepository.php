<?php

namespace App\Repository\Etxt;

use App\Entity\Etxt\EtxtTaskTextRestraints;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EtxtTaskTextRestraints|null find($id, $lockMode = null, $lockVersion = null)
 * @method EtxtTaskTextRestraints|null findOneBy(array $criteria, array $orderBy = null)
 * @method EtxtTaskTextRestraints[]    findAll()
 * @method EtxtTaskTextRestraints[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EtxtTaskTextRestraintsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EtxtTaskTextRestraints::class);
    }

    // /**
    //  * @return EtxtTaskTextRestraints[] Returns an array of EtxtTaskTextRestraints objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?EtxtTaskTextRestraints
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
