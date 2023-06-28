<?php

namespace App\Form;

use App\Entity\Participant;
use App\Entity\Site;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ParticipantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('lastname')
            ->add('firstname')
            ->add('phone')
            ->add('site',EntityType::class,[
                'class' => Site::class,
                'label' => 'Nom du site',
                'choice_label' => 'siteName',
                'multiple' => false,
                'required' => false
            ])
//            ->add('username',EntityType::class,[
//                'class' => User::class,
//                'label' => 'Username',
//                'choice_label' => 'username',
//                'multiple' => false,
//                'required' => false
//            ])
//            ->add('email',EntityType::class,[
//                'class' => User::class,
//                'label' => 'Email',
//                'choice_label' => 'email',
//                'multiple' => false,
//                'required' => false
//            ])
//            ->add('password',EntityType::class,[
//                'class' => User::class,
//                'label' => 'Password',
//                'choice_label' => 'password',
//                'multiple' => false,
//                'required' => false
//            ])
                ;

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Participant::class,
        ]);
    }
}
