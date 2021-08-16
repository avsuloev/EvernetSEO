<?php

namespace App\Repository;

use App\Entity\Keyword;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Keyword|null find($id, $lockMode = null, $lockVersion = null)
 * @method Keyword|null findOneBy(array $criteria, array $orderBy = null)
 * @method Keyword[]    findAll()
 * @method Keyword[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class KeywordRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Keyword::class);
    }

    public function getWithSearchQueryBuilder(?string $term): QueryBuilder
    {
        $qb = $this->createQueryBuilder('k')
            ->innerJoin('k.keywordGroup', 'kg')
            ->addSelect('kg');
        if ($term) {
            $qb
                ->andWhere('k.name LIKE :term OR k.url LIKE :term OR kg.name LIKE :term')
                ->setParameter('term', '%' . $term . '%')
            ;
        }
        return $qb
            ->orderBy('k.name', 'DESC')
        ;
    }

    /**
     * @todo: optimize query
     */
    public function getWithByProjectQueryBuilder(?string $pName): QueryBuilder
    {
        $qb = $this
            ->createQueryBuilder('k')
            ->innerJoin('k.keywordGroup', 'kg')
            ->addSelect('kg')
            ->innerJoin('kg.project', 'p')
            ->addSelect('p')
            ->andWhere('p.cmsTitle LIKE :pName')
            ->setParameter('pName', '%' . $pName . '%')
        ;

        return $qb->orderBy('k.name', 'DESC');
    }

    // /**
    //  * @return Keyword[] Returns an array of Keyword objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('k')
            ->andWhere('k.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('k.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Keyword
    {
        return $this->createQueryBuilder('k')
            ->andWhere('k.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
