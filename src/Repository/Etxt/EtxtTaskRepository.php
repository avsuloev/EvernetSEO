<?php

namespace App\Repository\Etxt;

use App\Entity\Etxt\EtxtTask;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EtxtTask|null find($id, $lockMode = null, $lockVersion = null)
 * @method EtxtTask|null findOneBy(array $criteria, array $orderBy = null)
 * @method EtxtTask[]    findAll()
 * @method EtxtTask[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EtxtTaskRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EtxtTask::class);
    }

    // /**
    //  * @return EtxtTask[] Returns an array of EtxtTask objects
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
    public function findOneBySomeField($value): ?EtxtTask
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
