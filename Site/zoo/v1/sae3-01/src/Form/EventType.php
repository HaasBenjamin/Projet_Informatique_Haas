<?php

namespace App\Form;

use App\Entity\Enclosure;
use App\Entity\Event;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, ['empty_data' => ''])
            ->add('description', TextType::class)
            ->add('date', DateTimeType::class, [
                'mapped' => false,
                'required' => false,
                'years' => [(int) date('Y'), (int) date('Y') + 1],
                'placeholder' => [
                    'year' => 'Année', 'month' => 'Mois', 'day' => 'Jour',
                    'hour' => 'Heure', 'minute' => 'Minutes',
                ],
            ])
            ->add('duration', NumberType::class)
            ->add('quota', NumberType::class)
            ->add('enclosure', EntityType::class, [
                'required' => false,
                'class' => Enclosure::class,
                'choice_label' => 'name',
                'query_builder' => function (EntityRepository $entityRepository) {
                    return $entityRepository->createQueryBuilder('e')
                        ->orderBy('e.name', 'ASC');
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
