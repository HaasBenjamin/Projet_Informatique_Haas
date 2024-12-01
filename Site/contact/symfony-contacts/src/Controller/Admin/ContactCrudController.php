<?php

namespace App\Controller\Admin;

use App\Entity\Contact;
use Doctrine\ORM\EntityRepository;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ContactCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Contact::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('firstname'),
            TextField::new('lastname'),
            EmailField::new('email'),
            TextField::new('phone'),
            AssociationField::new('category')->setFormTypeOptions(['choice_label' => 'name', 'query_builder' => function (EntityRepository $entityRepository) {
                return $entityRepository->createQueryBuilder('c')
                    ->orderBy('c.name', 'ASC');
            }, ])->formatValue(function ($value) {
                return $value?->getName();
            }),
        ];
    }
}
