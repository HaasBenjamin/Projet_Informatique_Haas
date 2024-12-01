<?php

namespace App\Controller\Admin;

use App\Entity\Event;
use Doctrine\ORM\EntityRepository;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class EventCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Event::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name'),
            TextField::new('description'),
            IntegerField::new('quota'),
            AssociationField::new('enclosure')->setFormTypeOptions([
                    'choice_label' => 'name',
                    'query_builder' => function (EntityRepository $entityRepository) {
                        return $entityRepository->createQueryBuilder('enc')
                            ->orderBy('enc.name', 'ASC');
                    },
                ])
                ->formatValue(function ($value) {
                    return $value?->getName();
                }),
        ];
    }
}
