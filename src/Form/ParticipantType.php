<?php

namespace App\Form;

use App\Entity\Participant;
use App\Entity\Site;
use App\Entity\User;
<<<<<<< HEAD
use Faker\Provider\Text;
=======
use PharIo\Manifest\Email;
>>>>>>> 80b8ac2a9b56050ad87a6b8c06e16ac8a6a85ec3
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Validator\Constraints as Assert;

use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ParticipantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
<<<<<<< HEAD

            ->add('lastname', TextType::class, [
                'label'=>'Nom'
            ])
            ->add('firstname', TextType::class, [
                'label'=>'Prénom'
            ])
            ->add('phone', TextType::class, [
                'label'=>'Télephone'
            ])
=======
            ->add('lastname', TextType::class,[
                'label' => 'Nom',
                'attr' => ['pattern' => '[a-zA-Z]*']
            ])
            ->add('firstname', TextType::class,[
                'label' => 'Prénom'
            ])
            ->add('phone')
>>>>>>> 80b8ac2a9b56050ad87a6b8c06e16ac8a6a85ec3
            ->add('site',EntityType::class,[
                'class' => Site::class,
                'label' => 'Site de rattachement',
                'choice_label' => 'siteName',
                'multiple' => false,
                'required' => false,
                'mapped' => false
            ])
<<<<<<< HEAD

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

=======
        ;
>>>>>>> 80b8ac2a9b56050ad87a6b8c06e16ac8a6a85ec3
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Participant::class,
        ]);
    }
}
