<?php

namespace App\Form;

use App\Entity\Site;
use App\Entity\UserProfile;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Mime\Part\File;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lastName',null,['label'=>'Nom : '])
            ->add('firstName',null,['label'=>'Prénom : '])
            ->add('phoneNumber',null,['label'=>'Téléphone : '])
            ->add('emailAdress',null,['label'=>'Email : '])
            ->add('site',EntityType::class,['label'=>'Campus : ','class'=>Site::class,'choice_label'=>'siteName']);

        if ($options['admin-mode'] === false){
            $builder->add('pictureFile',
                FileType::class,
                [
                    'label'=>'Image : ',
                    "required"=>false,
                    "mapped"=>false,
                    'constraints' => [
                        new \Symfony\Component\Validator\Constraints\File([
                            'mimeTypes' => [
                                'image/jpeg',
                                'image/png',
                                'image/jpg',
                            ],
                            'mimeTypesMessage' => 'Extensions autorisées : jpg, jpeg, png.',
                        ]),
                    ]
                ]);
        }

    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UserProfile::class,
            'admin-mode'=>false
        ]);
    }
}
