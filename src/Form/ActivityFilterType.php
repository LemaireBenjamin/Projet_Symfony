<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
class ActivityFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $isNotParticipant = $options['isNotParticipant'];
        $isParticipant = $options['isParticipant'];

        $builder
            ->add('site', ChoiceType::class, [
                'choices' => $options['sites'],
                'choice_label' => function($site) {
                    return $site->getSiteName();
                },
                'required' => false,
                'label' => 'Site',
            ])
            ->add('name', TextType::class, [
                'required' => false,
                'label' => 'Le nom de la sortie contient',
            ])
            ->add('startDate', DateType::class, [
                'widget' => 'single_text',
                'required' => false,
                'label' => 'Activités entre',
            ])
            ->add('endDate', DateType::class, [
                'widget' => 'single_text',
                'required' => false,
                'label' => 'et',
            ])
            ->add('isOrganizer', CheckboxType::class, [
                'required' => false,
                'label' => 'Sorties dont je suis l\'organisateur',
            ])

            ->add('isParticipant', CheckboxType::class, [
                'required' => false,
                'label' => 'Sorties auxquelles je suis inscrit',
                'attr' => [
                    'disabled' =>$isNotParticipant ? 'disabled' : null,
                ],
            ])
            ->add('isNotParticipant', CheckboxType::class, [
                'required' => false,
                'label' => 'Sorties auxquelles je ne suis pas inscrit',
                'attr' => [
                    'disabled' => $isParticipant ? 'disabled' : null,
                ],
            ])
            ->add('isPast', CheckboxType::class, [
                'required' => false,
                'label' => 'Sorties passées',
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Rechercher',
            ]);
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => null,
            'sites' => [], // Les sites disponibles (récupérés depuis la base de données)
            'isNotParticipant' => true,
            'isParticipant' => false,
        ]);
    }
}