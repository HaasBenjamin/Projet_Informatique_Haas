<?php

namespace App\Repository;

use App\Entity\Event;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Event>
 *
 * @method Event|null find($id, $lockMode = null, $lockVersion = null)
 * @method Event|null findOneBy(array $criteria, array $orderBy = null)
 * @method Event[]    findAll()
 * @method Event[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Event::class);
    }

    public function getAll(string $search): array
    {
        return $this->createQueryBuilder('e')
            ->leftJoin('e.enclosure', 'enclosure')
            ->addSelect('enclosure')
            ->Where('e.name LIKE :search')
            ->setParameter('search', '%'.$search.'%')
            ->orderBy('e.name')
            ->getQuery()
            ->execute();
    }

    public function getDateForEvent(string $eventName): array
    {
        $query = $this->createQueryBuilder('e');
        $query->select('eventDate.date')
            ->Join('e.eventDates', 'assoc')
            ->Join('assoc.eventDatesId', 'eventDate')
            ->Where('UPPER(e.name) = UPPER(:eventName)')
            ->setParameter('eventName', $eventName);

        return $query->getQuery()->execute();
    }

    public function getHours(string $eventName): array
    {
        $dates = $this->getDateForEvent($eventName);
        $hoursAvailable = [];
        foreach ($dates as $date) {
            $hoursAvailable[] = date_parse_from_format('Y-m-d H:i:s', $date['date']->format('Y-m-d H:i:s'))['hour'];
        }

        return $hoursAvailable;
    }

    public function getMinutes(string $eventName): array
    {
        $dates = $this->getDateForEvent($eventName);
        $minAvailable = [];
        foreach ($dates as $date) {
            $minAvailable[] = date_parse_from_format('Y-m-d H:i:s', $date['date']->format('Y-m-d H:i:s'))['minute'];
        }

        return $minAvailable;
    }
    //    /**
    //     * @return Event[] Returns an array of Event objects
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

    //    public function findOneBySomeField($value): ?Event
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
