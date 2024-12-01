<?php

namespace App\Controller\Admin;

use App\Entity\Registration;
use Doctrine\ORM\EntityRepository;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;

class RegistrationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Registration::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            DateTimeField::new('date'),
            IntegerField::new('nbReservedPlaces'),
            AssociationField::new('event')->setFormTypeOptions([
                'choice_label' => 'name',
                'query_builder' => function (EntityRepository $entityRepository) {
                    return $entityRepository->createQueryBuilder('ev')
                        ->orderBy('ev.name', 'ASC');
                },
            ])
                ->formatValue(function ($value) {
                    return $value?->getName();
                }),

            AssociationField::new('user')->setFormTypeOptions([
                'choice_label' => 'email',
                'query_builder' => function (EntityRepository $entityRepository) {
                    return $entityRepository->createQueryBuilder('u')
                        ->orderBy('u.email', 'ASC');
                },
            ])
                ->formatValue(function ($value) {
                    return $value?->getEmail();
                }),
        ];
    }
}
