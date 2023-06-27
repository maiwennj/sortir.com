<?php

namespace App\Form;

use App\Entity\Site;
use App\Entity\UserProfile;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lastName')
            ->add('firstName')
            ->add('phoneNumber')
            ->add('emailAdress')
            ->add('site',EntityType::class,['label'=>'Site : ','class'=>Site::class,'choice_label'=>'siteName'])
        ;
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UserProfile::class,
        ]);
    }
}
