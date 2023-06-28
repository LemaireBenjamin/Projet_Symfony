<?php

namespace App\Form;

use App\Entity\Activity;
use App\Entity\City;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\DateTime;


class ActivityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',TextType::class, [
                'label' => 'Un nom pour votre activité'
            ])
            ->add('startDate', DateType::class, [
                'label' => 'Date de début',
                'attr' => ['placeholder' => 'jj/mm/aaaa'],
                'constraints' => [new DateTime(['format' => 'D/M/Y'])]
                ])
            ->add('duration')
            ->add('endDate')
            ->add('maxInscriptions')
            ->add('description')
            ->add('pictureUrl', FileType::class, [
                'label' => 'Image',
                'required' => false,
                'attr' => [
                    'accept' => 'image/*', // Permet de filtrer les fichiers par extension d'image
                ]])
            ->add('city', EntityType::class, [
                'mapped'=> false,
                'class' => City::class,
                'choice_label' => 'cityName'])
        ;
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Activity::class,
        ]);
    }
}
