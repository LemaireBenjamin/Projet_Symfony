<?php

namespace App\Form;

use App\Entity\Activity;
use App\Entity\City;
use App\Entity\Place;
use App\Entity\Site;
use App\Entity\Status;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class ActivityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',TextType::class, [
                'label' => 'Un nom pour votre activité'
            ])
            ->add('startDate')
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
            ->add('site', EntityType::class, [
//                'mapped'=> true,
                'class' => Site::class,
                'choice_label' => 'siteName'])

            ->add('place', EntityType::class, [
                'mapped'=> false,
                'multiple' => false,
                'expanded' =>false,
                'class' => Place::class,
                'choice_label' => 'placeName'])

            ->add('placeStreet', EntityType::class, [
                'mapped'=> false,
                'class' => Place::class,
                'choice_label' => 'placeStreet'])

        ;
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Activity::class,
        ]);
    }
}
