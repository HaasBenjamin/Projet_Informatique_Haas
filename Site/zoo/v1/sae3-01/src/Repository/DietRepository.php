<?php

namespace App\Repository;

use App\Entity\AnimalDiet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AnimalDiet>
 *
 * @method AnimalDiet|null find($id, $lockMode = null, $lockVersion = null)
 * @method AnimalDiet|null findOneBy(array $criteria, array $orderBy = null)
 * @method AnimalDiet[]    findAll()
 * @method AnimalDiet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DietRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AnimalDiet::class);
    }

    //    /**
    //     * @return AnimalDiet[] Returns an array of AnimalDiet objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('r.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?AnimalDiet
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
