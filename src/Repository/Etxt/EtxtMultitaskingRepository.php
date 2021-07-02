<?php

namespace App\Repository\Etxt;

use App\Entity\Etxt\EtxtMultitasking;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EtxtMultitasking|null find($id, $lockMode = null, $lockVersion = null)
 * @method EtxtMultitasking|null findOneBy(array $criteria, array $orderBy = null)
 * @method EtxtMultitasking[]    findAll()
 * @method EtxtMultitasking[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EtxtMultitaskingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EtxtMultitasking::class);
    }

    // /**
    //  * @return EtxtMultitasking[] Returns an array of EtxtMultitasking objects
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
    public function findOneBySomeField($value): ?EtxtMultitasking
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
