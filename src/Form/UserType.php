<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use function Sodium\add;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void{
        $builder
            ->add('username',null,['label'=>'Pseudo : ']);


            if ($options['admin-mode']=== false){
                $builder->add('password',RepeatedType::class, [
                    'type' => PasswordType::class,
                    'first_options'  => ['label' => 'Mot de passe : ', 'hash_property_path' => 'password'],
                    'second_options' => ['label' => 'Confirmation : '],
                    'mapped' => false])
                    ->add('userProfile',UserProfileType::class,['label'=>'Données utilisateur','admin-mode'=>false]);;
            }else{
                $builder->add('isAdmin',CheckboxType::class,['label'=>'Admin ?','required'=>false])
                ->add('isActive',CheckboxType::class,['label'=>'Actif ?','required'=>false])
                    ->add('userProfile',UserProfileType::class,['label'=>'Données utilisateur','admin-mode'=>true]);;
            }

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'admin-mode'=>false
        ]);
    }
}
