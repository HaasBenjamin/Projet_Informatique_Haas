<?php

namespace App\Repository;

use App\Entity\AnimalCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AnimalCategory>
 *
 * @method AnimalCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method AnimalCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method AnimalCategory[]    findAll()
 * @method AnimalCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnimalCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AnimalCategory::class);
    }

    /**
     * Listage des catégories avec leurs familles.
     *
     * @return AnimalCategory[]
     */
    public function getAllCategories(string $search): array
    {
        $qb = $this->createQueryBuilder('c');
        $qb->leftJoin('c.animalFamilies', 'families')
            ->leftJoin('c.image', 'image')
            ->addSelect('families')
            ->addSelect('image')
            ->where('c.name LIKE :search')
            ->setParameter('search', '%'.$search.'%')
            ->orderBy('c.name')
            ->groupBy('c.id');

        return $qb->getQuery()->execute();
    }

    public function getAllFamilies(int $idCategory, string $search): array
    {
        $qb = $this->createQueryBuilder('c');
        $qb->leftJoin('c.animalFamilies', 'families')
            ->leftJoin('families.image', 'images')
            ->addSelect('images')
            ->addSelect('families')
            ->where('c.id = :id')
            ->andWhere('families.name LIKE :search')
            ->setParameter('id', $idCategory)
            ->setParameter('search', '%'.$search.'%');

        return $qb->getQuery()->execute();
    }

    //    /**
    //     * @return AnimalCategory[] Returns an array of AnimalCategory objects
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

    //    public function findOneBySomeField($value): ?AnimalCategory
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
