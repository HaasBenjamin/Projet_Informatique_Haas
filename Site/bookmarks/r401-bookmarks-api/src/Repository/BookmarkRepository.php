<?php

namespace App\Repository;

use App\Entity\Bookmark;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Bookmark>
 *
 * @method Bookmark|null find($id, $lockMode = null, $lockVersion = null)
 * @method Bookmark|null findOneBy(array $criteria, array $orderBy = null)
 * @method Bookmark[]    findAll()
 * @method Bookmark[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookmarkRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Bookmark::class);
    }

    public function updateRateAverage(int $bookmarkId): void
    {
        $qb = $this->createQueryBuilder('book');
        $qb->select('AVG(ratings.value)')
            ->join('book.ratings', 'ratings')
            ->where('book.id = :id')
            ->setParameter('id', $bookmarkId);
        $average = $qb->getQuery()->execute()[0][1];
        $qb = $this->createQueryBuilder('book');
        $qb->update();
        $qb->set('book.rateAverage', ':avg')
            ->where('book.id = :id')
            ->setParameter('id', $bookmarkId)
            ->setParameter('avg', $average ?? 0);
        $qb->getQuery()->execute();
    }

    //    /**
    //     * @return Bookmark[] Returns an array of Bookmark objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('b.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Bookmark
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
