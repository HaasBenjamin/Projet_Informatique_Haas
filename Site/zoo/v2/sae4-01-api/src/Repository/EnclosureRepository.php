<?php

namespace App\Repository;

use App\Entity\Enclosure;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Enclosure>
 *
 * @method Enclosure|null find($id, $lockMode = null, $lockVersion = null)
 * @method Enclosure|null findOneBy(array $criteria, array $orderBy = null)
 * @method Enclosure[]    findAll()
 * @method Enclosure[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EnclosureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Enclosure::class);
    }

//    /**
//     * @return Enclosure[] Returns an array of Enclosure objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Enclosure
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
