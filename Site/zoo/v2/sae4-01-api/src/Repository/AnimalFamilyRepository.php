<?php

namespace App\Repository;

use App\Entity\AnimalFamily;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AnimalFamily>
 *
 * @method AnimalFamily|null find($id, $lockMode = null, $lockVersion = null)
 * @method AnimalFamily|null findOneBy(array $criteria, array $orderBy = null)
 * @method AnimalFamily[]    findAll()
 * @method AnimalFamily[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnimalFamilyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AnimalFamily::class);
    }

//    /**
//     * @return AnimalFamily[] Returns an array of AnimalFamily objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?AnimalFamily
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
