<?php

namespace App\Form;

use App\Entity\Location;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LocationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('locationName',null,['label' => "Nom du lieu : ",'required' => true])
            ->add('street',null,['label' => "Ville : ",'required' => true])
            ->add('latitude',null,['label' => "Latitude : ",'required' => true])
            ->add('longitude',null,['label' => "Longitude : ",'required' => true])
            ->add('city',null,['label' => "Rue : ",'required' => true])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Location::class,
        ]);
    }
}
