<?php

declare(strict_types=1);

namespace Api\AnimalCategory;

use App\Entity\AnimalCategory;
use App\Factory\AnimalCategoryFactory;
use App\Tests\Support\ApiTester;

class AnimalCategoryGetCollectionCest
{
    public function getAnimalCategoryCollection(ApiTester $I): void
    {
        AnimalCategoryFactory::createMany(6);
        $I->sendGet('/api/animal_categories');
        $I->seeResponseIsJson();
        $I->seeResponseIsACollection(AnimalCategory::class, '/api/animal_categories', [
            'hydra:member' => 'array',
            'hydra:totalItems' => 'integer',
        ]);
        $I->seeResponseContainsJson([
            'hydra:totalItems' => 6,
        ]);

    }
}
