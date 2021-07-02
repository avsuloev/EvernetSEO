<?php

namespace App\Repository\Etxt;

use App\Entity\Etxt\EtxtTaskType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EtxtTaskType|null find($id, $lockMode = null, $lockVersion = null)
 * @method EtxtTaskType|null findOneBy(array $criteria, array $orderBy = null)
 * @method EtxtTaskType[]    findAll()
 * @method EtxtTaskType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EtxtTaskTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EtxtTaskType::class);
    }

    // /**
    //  * @return EtxtTaskType[] Returns an array of EtxtTaskType objects
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
    public function findOneBySomeField($value): ?EtxtTaskType
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
