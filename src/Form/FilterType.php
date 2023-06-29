<?php

namespace App\Form;

use App\Entity\Site;
use App\Model\Filter;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use function Symfony\Component\Clock\now;


class FilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'keyWord',
                null,
                [
                    'label'=>'Le nom de la sortie contient :  '

                ])
            ->add("site", EntityType::class,
            [
                "required"=>false,
                'label'=>'Site :  ',
                "placeholder"=>"Choisir un site",
                "class"=>Site::class,
                "choice_label"=>"siteName"
            ])
            ->add(
                'startDate',
                DateType::class,
                [
                    "required"=>false,
                    'label'=>'Entre ',
                    'widget'=>'single_text',
//                    'empty_data' => (new \DateTime())->format('Y-m-d'),
                ]
            )
            ->add(
                'endDate',
                DateType::class,
                [
                    "required"=>false,
                    'label'=>'et ',
                    'widget'=>'single_text'
                ]
            )
            ->add(
                'isTheOrganiser',
                CheckboxType::class,
                [
                    "required"=>false,
                    "label"=>"Sorties dont je suis l'organisteur/trice "
                ]
            )
            ->add(
                'isRegistered',
                CheckboxType::class,
                [
                    "required"=>false,
                    "label"=>"Sorties auxquelles je suis inscrit/e "
                ]
            )
            ->add(
                'isNotRegistered',
                CheckboxType::class,
                [
                    "required"=>false,
                    "label"=>"Sorties auxquelles je ne suis pas inscrit/e "
                ]
            )
            ->add(
                'isFinished',
                CheckboxType::class,
                [
                    "required"=>false,
                    "label"=>"Sorties passées "
                ]
            )
            ->add("submit",
                SubmitType::class,
                [
                    "label"=>'Rechercher',

                ])
            ->add("reset",
                ResetType::class,
                [
                    "label"=>'Vider les champs',

                ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            "data_class"=> Filter::class
        ]);
    }
}
