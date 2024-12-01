<?php

namespace App\Controller\Admin;

use App\Entity\Animal;
use Doctrine\ORM\EntityRepository;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class AnimalCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Animal::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
            TextField::new('description'),
            AssociationField::new('species')
                ->setFormTypeOptions(
                    ['choice_label' => 'name',
                        'query_builder' => function (EntityRepository $entityRepository) {
                            return $entityRepository->createQueryBuilder('s')
                                ->orderBy('s.name', 'ASC');
                        }, ])->formatValue(function ($value) {
                            return $value?->getName();
                        }),

            AssociationField::new('enclosure')
                ->setFormTypeOptions(
                    ['choice_label' => 'name',
                        'query_builder' => function (EntityRepository $entityRepository) {
                            return $entityRepository->createQueryBuilder('e')
                                ->orderBy('e.name', 'ASC');
                        }, ])->formatValue(function ($value) {
                            return $value?->getName();
                        }),
        ];
    }
}
