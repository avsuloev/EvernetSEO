<?php

namespace App\Repository\Etxt;

use App\Entity\Etxt\EtxtTasksAutoAccept;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EtxtTasksAutoAccept|null find($id, $lockMode = null, $lockVersion = null)
 * @method EtxtTasksAutoAccept|null findOneBy(array $criteria, array $orderBy = null)
 * @method EtxtTasksAutoAccept[]    findAll()
 * @method EtxtTasksAutoAccept[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EtxtTasksAutoAcceptRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EtxtTasksAutoAccept::class);
    }

    // /**
    //  * @return EtxtTasksAutoAccept[] Returns an array of EtxtTasksAutoAccept objects
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
    public function findOneBySomeField($value): ?EtxtTasksAutoAccept
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
