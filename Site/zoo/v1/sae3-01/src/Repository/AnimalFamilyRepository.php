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

    public function getAllSpecies(int $idFamily, string $search): array
    {
        $qb = $this->createQueryBuilder('f');
        $qb->leftJoin('f.species', 'species')
            ->leftJoin('species.image', 'images')
            ->leftjoin('species.diet', 'diet')
            ->addSelect('diet')
            ->addSelect('images')
            ->addSelect('species')
            ->where('f.id = :id')
            ->andWhere('species.name LIKE :search')
            ->setParameter('id', $idFamily)
            ->setParameter('search', '%'.$search.'%');

        return $qb->getQuery()->execute();
    }

    /**
     * @return AnimalFamily[]
     */
    public function getAllFamiliesWithPicture(string $search): array
    {
        $qb = $this->createQueryBuilder('f');
        $qb->leftJoin('f.image', 'image')
            ->addSelect('image')
            ->where('f.name LIKE :search')
            ->setParameter('search', '%'.$search.'%')
            ->orderBy('f.name');

        return $qb->getQuery()->execute();
    }

    //    /**
    //     * @return AnimalFamily[] Returns an array of AnimalFamily objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('f')
    //            ->andWhere('f.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('f.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?AnimalFamily
    //    {
    //        return $this->createQueryBuilder('f')
    //            ->andWhere('f.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
