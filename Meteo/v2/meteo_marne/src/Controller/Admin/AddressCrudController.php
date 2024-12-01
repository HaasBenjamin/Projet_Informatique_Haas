<?php

namespace App\Controller\Admin;

use App\Entity\Address;
use Doctrine\DBAL\Types\IntegerType;
use Doctrine\ORM\EntityRepository;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class AddressCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Address::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('city'),
            IntegerField::new('postalCode'),
            TextField::new('addressSupplement'),
            AssociationField::new('user')->setFormTypeOptions(['choice_label' => 'lastName', 'query_builder' => function (EntityRepository $entityRepository) {
                return $entityRepository->createQueryBuilder('u')
                    ->orderBy('u.lastName', 'ASC');
            }, ])->formatValue(function ($value) {
                return $value?->getLastName();
            }),

        ];
    }

}
