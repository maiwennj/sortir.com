<?php

namespace App\Form;

use App\Entity\Site;
use App\Model\Filter;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('keyWord')
            ->add("site", EntityType::class,
            [
                "required"=>false,
                'empty_data'=>"Tout les sites",
                "class"=>Site::class,
                "choice_label"=>"siteName"
            ])
            ->add("submit", SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            "data_class"=> Filter::class
        ]);
    }
}
