<?php

namespace App\Form;

use App\Entity\Activity;
use App\Entity\City;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ActivityType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class)
            ->add('startDate', \DateTime::class)
            ->add('duration' )
            ->add('endDate')
            ->add('maxInscriptions')
            ->add('description')
            ->add('activityStatus')
            ->add('pictureUrl')
            ->add('city', EntityType::class, [
                'mapped'=>false,
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
