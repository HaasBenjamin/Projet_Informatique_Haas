<?php

namespace App\Controller\Admin;

use App\Entity\Species;
use Doctrine\ORM\EntityRepository;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class SpeciesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Species::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name'),
            TextField::new('description'),
            AssociationField::new('diet')
            ->setFormTypeOptions([
                'choice_label' => 'name',
                'query_builder' => function (EntityRepository $entityRepository) {
                    return $entityRepository->createQueryBuilder('diet')
                        ->orderBy('diet.name', 'ASC');
                },
            ])
            ->formatValue(function ($value) {
                return $value?->getName();
            }),
            AssociationField::new('family')
            ->setFormTypeOptions([
                'choice_label' => 'name',
                'query_builder' => function (EntityRepository $entityRepository) {
                    return $entityRepository->createQueryBuilder('family')
                        ->orderBy('family.name', 'ASC');
                },
            ])
            ->formatValue(function ($value) {
                return $value?->getName();
            }),

            AssociationField::new('animals')
                ->onlyOnForms()
                ->setFormTypeOptions([
                    'multiple' => true,
                    'choice_label' => 'name',
                ]),
        ];
    }
}
