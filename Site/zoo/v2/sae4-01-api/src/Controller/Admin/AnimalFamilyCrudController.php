<?php

namespace App\Controller\Admin;

use App\Entity\AnimalCategory;
use App\Entity\AnimalFamily;
use Doctrine\ORM\EntityRepository;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class AnimalFamilyCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return AnimalFamily::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name'),
            TextEditorField::new('description'),
            AssociationField::new('category')
                ->setFormTypeOptions([
                    'placeholder' => 'Catégorie',
                    'choice_label' => 'name',
                    'query_builder' => function (EntityRepository $entityRepository) {
                        return $entityRepository->createQueryBuilder('c')
                            ->orderBy('c.name', 'ASC');
                    },
                ])
                ->formatValue(function (AnimalCategory $category) {
                    return $category->getName() ?: 'Aucune';
                }),
        ];
    }
}
