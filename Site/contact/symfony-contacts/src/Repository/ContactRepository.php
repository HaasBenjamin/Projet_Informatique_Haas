<?php

namespace App\Repository;

use App\Entity\Contact;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Contact>
 *
 * @method Contact|null find($id, $lockMode = null, $lockVersion = null)
 * @method Contact|null findOneBy(array $criteria, array $orderBy = null)
 * @method Contact[]    findAll()
 * @method Contact[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContactRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Contact::class);
    }

    /**
     * @return Contact[]
     */
    public function search(string $value = ''): array
    {
        $qb = $this->createQueryBuilder('c');
        $qb->where('UPPER(c.lastname) LIKE UPPER(:value) OR UPPER(c.firstname) LIKE UPPER(:value)')
            ->leftJoin('c.category', 'cat')
            ->addSelect('cat')
            ->orderBy('c.lastname,c.firstname', 'ASC')
            ->setParameter('value', '%'.$value.'%');

        $query = $qb->getQuery();

        return $query->execute();
    }

    public function findWithCategory(int $id): ?Contact
    {
        $qb = $this->createQueryBuilder('c');
        $qb->leftJoin('c.category', 'category')
            ->addSelect('category')
            ->where('c.id = :id')
            ->setParameter('id', $id);

        return $qb->getQuery()->getOneOrNullResult();
    }

    //    /**
    //     * @return Contact[] Returns an array of Contact objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Contact
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
