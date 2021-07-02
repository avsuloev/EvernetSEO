<?php

namespace App\Repository\Etxt;

use App\Entity\Etxt\EtxtAuthor;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EtxtAuthor|null find($id, $lockMode = null, $lockVersion = null)
 * @method EtxtAuthor|null findOneBy(array $criteria, array $orderBy = null)
 * @method EtxtAuthor[]    findAll()
 * @method EtxtAuthor[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EtxtAuthorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EtxtAuthor::class);
    }

    // /**
    //  * @return EtxtAuthor[] Returns an array of EtxtAuthor objects
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
    public function findOneBySomeField($value): ?EtxtAuthor
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
