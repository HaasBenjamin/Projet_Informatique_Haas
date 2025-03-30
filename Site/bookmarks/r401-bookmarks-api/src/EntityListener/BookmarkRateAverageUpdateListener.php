<?php

namespace App\EntityListener;

use App\Entity\Rating;
use App\Repository\BookmarkRepository;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;

#[AsEntityListener(event: Events::postPersist, entity: Rating::class)]
#[AsEntityListener(event: Events::postUpdate, entity: Rating::class)]
#[AsEntityListener(event: Events::postRemove, entity: Rating::class)]
class BookmarkRateAverageUpdateListener
{
    public function __construct(
        private BookmarkRepository $bookmarkRepository
    ) {
    }

    public function postPersist(Rating $rating, LifecycleEventArgs $event): void
    {
        $this->bookmarkRepository->updateRateAverage($rating->getBookmark()->getId());
    }

    public function postUpdate(Rating $rating, LifecycleEventArgs $event): void
    {
        $this->bookmarkRepository->updateRateAverage($rating->getBookmark()->getId());
    }

    public function postRemove(Rating $rating, LifecycleEventArgs $event): void
    {
        $this->bookmarkRepository->updateRateAverage($rating->getBookmark()->getId());
    }
}
