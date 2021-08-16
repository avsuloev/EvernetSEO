<?php

namespace App\Repository;

use App\Entity\KeywordGroup;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepositoryInterface;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Gedmo\Tree\Entity\Repository\NestedTreeRepository;
use LogicException;

use function sprintf;

/**
 * @method KeywordGroup|null find($id, $lockMode = null, $lockVersion = null)
 * @method KeywordGroup|null findOneBy(array $criteria, array $orderBy = null)
 * @method KeywordGroup[]    findAll()
 * @method KeywordGroup[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class KeywordGroupRepository extends NestedTreeRepository implements ServiceEntityRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        $entityClass = KeywordGroup::class;
        $manager = $registry->getManagerForClass($entityClass);

        if (null === $manager) {
            throw new LogicException(sprintf('Could not find the entity manager for class "%s". Check your Doctrine configuration to make sure it is configured to load this entity’s metadata.', $entityClass, ));
        }

        parent::__construct($manager, $manager->getClassMetadata($entityClass));
    }

    public function findAllSupersIds(string $id)
    {
    }

    public function findAllExcludingAllSuper(string $id): QueryBuilder
    {
        // linked_key_groups
        // linked_group_id
        return $this->createQueryBuilder('k')
            ->andWhere('k.id = :id')
            ->setParameter('id', $id)
            ->orderBy('k.id', 'ASC')
            // ->setMaxResults(10)
        ;
    }

    public function findAllSubsIds(string $id)
    {
    }

    public function findAllExcludingAllSub(string $id): QueryBuilder
    {
        // group_id
        return $this->createQueryBuilder('k')
            ->andWhere('k.is_excluded_as_sub = false')
            ->andWhere('k.is_excluded_as_sub = false')
            ->setParameter('id', $id)
            ->orderBy('k.id', 'ASC')
            // ->setMaxResults(10)
        ;
    }

    // /**
    //  * @return KeywordGroup[] Returns an array of KeywordGroup objects
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
    public function findOneBySomeField($value): ?KeywordGroup
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
