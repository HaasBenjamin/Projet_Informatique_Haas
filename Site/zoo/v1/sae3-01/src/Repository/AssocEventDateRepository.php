<?php

namespace App\Repository;

use App\Entity\AssocEventDate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AssocEventDate>
 *
 * @method AssocEventDate|null find($id, $lockMode = null, $lockVersion = null)
 * @method AssocEventDate|null findOneBy(array $criteria, array $orderBy = null)
 * @method AssocEventDate[]    findAll()
 * @method AssocEventDate[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AssocEventDateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AssocEventDate::class);
    }

    //    /**
    //     * @return AssocEventDate[] Returns an array of AssocEventDate objects
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

    //    public function findOneBySomeField($value): ?AssocEventDate
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
    public function getAllDatesForEvent(?int $eventId)
    {
        $query = $this->createQueryBuilder('asso');
        $query
            ->leftJoin('asso.eventDatesId', 'dates')
            ->addSelect('dates')
            ->where('asso.eventId = :eventId')
            ->setParameter('eventId', $eventId);

        return $query->getQuery()->execute();
    }
}
