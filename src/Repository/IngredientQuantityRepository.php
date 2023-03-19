<?php

namespace App\Repository;

use App\Entity\IngredientQuantity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<IngredientQuantity>
 *
 * @method IngredientQuantity|null find($id, $lockMode = null, $lockVersion = null)
 * @method IngredientQuantity|null findOneBy(array $criteria, array $orderBy = null)
 * @method IngredientQuantity[]    findAll()
 * @method IngredientQuantity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IngredientQuantityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, IngredientQuantity::class);
    }

    public function save(IngredientQuantity $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(IngredientQuantity $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return IngredientQuantity[] Returns an array of IngredientQuantity objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('i.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?IngredientQuantity
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
