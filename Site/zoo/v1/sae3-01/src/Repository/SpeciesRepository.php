<?php

namespace App\Repository;

use App\Entity\Species;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Species>
 *
 * @method Species|null find($id, $lockMode = null, $lockVersion = null)
 * @method Species|null findOneBy(array $criteria, array $orderBy = null)
 * @method Species[]    findAll()
 * @method Species[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SpeciesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Species::class);
    }

    public function getAllAnimals(int $idSpecies, string $search): array
    {
        $qb = $this->createQueryBuilder('e');
        $qb->leftJoin('e.animals', 'animals')
            ->leftjoin('animals.image', 'image')
            ->addSelect('image')
            ->addSelect('animals')
            ->where('e.id = :id')
            ->andWhere('animals.name LIKE :search')
            ->setParameter('id', $idSpecies)
            ->setParameter('search', '%'.$search.'%');

        return $qb->getQuery()->execute();
    }

    /**
     * @return Species[]
     */
    public function getAllSpeciesWithPicture(string $search): array
    {
        $qb = $this->createQueryBuilder('e');
        $qb->leftJoin('e.image', 'image')
            ->leftJoin('e.diet', 'diet')
            ->leftJoin('e.animals', 'animals')
            ->addSelect('animals')
            ->addSelect('diet')
            ->addSelect('image')
            ->Where('e.name LIKE :search')
            ->setParameter('search', '%'.$search.'%')
            ->orderBy('e.name');

        return $qb->getQuery()->execute();
    }

    //    /**
    //     * @return Species[] Returns an array of Species objects
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

    //    public function findOneBySomeField($value): ?Species
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
