<?php

declare(strict_types=1);

namespace Api\AnimalCategory;

use App\Entity\AnimalCategory;
use App\Factory\AnimalCategoryFactory;
use App\Tests\Support\ApiTester;

class AnimalCategoryGetCest
{
    protected static function expectedProperties(): array
    {
        return [
            'id' => 'integer',
            'name' => 'string',
            'description' => 'string',
            'animalFamilies' => 'array',
            'image' => 'string',
        ];
    }

    public function getAnimalCategoryDetail(ApiTester $I): void
    {
        $data = [
            'name' => 'Poisson',
            'description' => 'description',
        ];

        AnimalCategoryFactory::createOne($data);
        $I->sendGet('/api/animal_categories/1');
        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseIsJson();
        $I->seeResponseIsAnEntity(AnimalCategory::class, '/api/animal_categories/1');
        $I->seeResponseIsAnItem(self::expectedProperties(), $data);
    }

}
