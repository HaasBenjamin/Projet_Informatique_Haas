<?php

namespace App\Form;

use App\Entity\Animal;
use App\Entity\Enclosure;
use App\Entity\Species;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class AnimalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, ['empty_data' => ''])
            ->add('description', null, ['empty_data' => ''])
            ->add('enclosure', EntityType::class, [
                'class' => Enclosure::class,
                'choice_label' => 'name',
                'required' => true,
                'query_builder' => function (EntityRepository $entityRepository) {
                    return $entityRepository->createQueryBuilder('e')
                        ->orderBy('e.name', 'ASC');
                }])
            ->add('species', EntityType::class, [
                'class' => Species::class,
                'choice_label' => 'name',
                'required' => true,
                'query_builder' => function (EntityRepository $entityRepository) {
                    return $entityRepository->createQueryBuilder('e')
                        ->orderBy('e.name', 'ASC');
                },
                ])
            ->add('image', FileType::class, [
                'data_class' => null,
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/png',
                            'image/jpeg',
                        ]]),
            ]])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Animal::class,
            'csrf_protection' => false,
        ]);
    }
}
