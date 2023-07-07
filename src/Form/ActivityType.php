<?php

namespace App\Form;

use App\Entity\Activity;
use App\Entity\City;
use App\Entity\Place;
use App\Entity\Site;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;



class ActivityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
//        date_default_timezone_set('Europe/Paris');
//        $defaultEndDate = new \DateTime();
//        $defaultEndDate->modify('+7 days');

        $builder
            ->add('name',TextType::class, [
                'label' => 'Nom de la sortie :'])

            ->add('site', EntityType::class, [
                'class' => Site::class,
                'choice_label' => 'siteName'
            ])

            ->add('cities', EntityType::class, [
                'mapped' => false,
                'class' => City::class,
                'choice_label' => 'cityName',
                'placeholder' => 'Sélectionnez un ville',
                'label' => 'Ville :'
            ])

            ->add('places', ChoiceType::class, [
                'mapped'=> false,
                'disabled' => false,
                'label' => 'Lieu :'
            ])

            ->add('placeId', HiddenType::class, [
                'mapped'=> false,
                'disabled' => true,
                'attr' => [
                    'hidden' => true,
                ],
            ])

            ->add('placeStreet', TextType::class, [
                'mapped'=> false,
                'attr' => ['id' => 'activity_placeStreet'],
                'label' => 'Rue :'
            ])

            ->add('zipCode', TextType::class, [
                'mapped'=> false,
                'label' => 'Code postal :'
            ])

            ->add('latitude', TextType::class, [
                'mapped'=> false,
                'label' => 'Latitude :'
            ])

            ->add('longitude', TextType::class, [
                'mapped'=> false,
                'label' => 'Longitude :'
            ])

            ->add('startDate', DateTimeType::class, [
                'label' => 'Date de la sortie :',
                'widget' => 'single_text',
                'data' => new \DateTime(),
//                'html5'=> false,
                'by_reference' => true,
                'attr' => [
                    'id' => ('form_startDate'),
                ],
            ])

            ->add('duration')
            ->add('endDate', DateTimeType::class, [
                'widget' => 'single_text',
                'html5' => true,
                'data' => new \DateTime('+7 days'),
                'attr' => [
                    'min' => (new \DateTime('+7 days'))->format('d/m/Y'),
                ],
                'by_reference' => true,
            ])
            ->add('maxInscriptions')
            ->add('description', TextareaType::class)
//            ->add('pictureUrl', FileType::class, [
//                'label' => 'Image',
//                'required' => false,
//                'attr' => ['accept' => 'image/*']])
            ->add('submit', SubmitType::class, [
                'label' => 'Valider',
            ]);
        ;

        $formModifier = function(FormInterface $form, City $city = null){
            $places = (null === $city) ? [] : $city->getPlaces();
            $form->add('places', EntityType::class, [
                    'mapped' => false,
                    'class' => Place::class,
                    'choices' => $places,
                    'choice_label' => 'placeName',
                    'placeholder' => 'Choisir un lieu',
                    'label' => 'Lieu',
            ]);
        };

        $builder->get('cities')->addEventListener(
            FormEvents::POST_SUBMIT,
            function(FormEvent $event) use ($formModifier) {
                $city = $event->getForm()->getData();
                $formModifier($event->getForm()->getParent(), $city);

                $form = $event->getForm()->getParent();
                $selectedPlace = $form->get('places')->getData();
                if ($selectedPlace) {
                    $placeStreet = $selectedPlace->getPlaceStreet();
                    $form->get('placeStreet')->setData($placeStreet);
                }
            }
        );
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Activity::class,
//            'attr' => ['id' => 'activity_form'],
        ]);
    }
}
