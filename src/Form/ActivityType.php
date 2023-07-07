<?php

namespace App\Form;

use App\Entity\Activity;

use App\Entity\City;

use App\Entity\Location;
use App\Entity\Site;
use DateInterval;
use phpDocumentor\Reflection\Types\String_;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Clock\Clock;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateIntervalType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use function Symfony\Component\Clock\now;

class ActivityType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options): void{

        $entity = $options['data'];

        if ($options['cancel_mode'] === true) {
            $builder->add('cancellationReason', TextareaType::class, [
                'label' => "Motif d'annulation",
                'required' => true,
            ]);
        }
      
        if ($options['cancel_mode'] === false) {
            $builder
                ->add('activityName', null, [
                    'label' => 'Nom de la sortie :'])
                ->add('startDate', null, [
                    'label' => 'Date et heure de la sortie :',
                    'widget' => 'single_text'])
                ->add('startDate', DateTimeType::class, [

                    'widget' => 'single_text',


                ])
                ->add('closingDate', DateTimeType::class, [
                    'label' => "Date limite d'inscription :"])
                ->add('startDate', DateTimeType::class, [

                    'widget' => 'single_text',
                    //'data' => new \DateTime(),
                    'by_reference' => true,

                ])
                ->add('closingDate', DateTimeType::class, [
                    'label' => "Date limite d'inscription :",

                    'widget' => 'single_text',
                    //'data' => new \DateTime(),
                    'by_reference' => true,
                ])



                ->add('maxRegistration', null, [
                'label' => 'Nombre de places :',
                'attr' => [
                    'min' => 1,
                    'value' => "1",
                ]])
                ->add('duration', null,
                    [
                        'label' => 'Durée :',
                        'attr' => [
                            'min' => 30,
                            'value' => "30",
                        ]
                    ])
                ->add('description', null, [
                    'label' => 'Description et infos :'])

//                ->add('city', EntityType::class, [
//                    'label' => 'Ville :',
//                    'class' => City::class,
//                    'choice_label' => 'cityName',
//                    'required' => false,
//                    'mapped' => false])

                ->add('site', EntityType::class, [
                    'label' => 'Campus :',
                    'class' => Site::class,
                    'choice_label' => 'siteName']);

            if ($entity->getLocation() == null){
                $builder->add('city', EntityType::class, [
                    'label' => 'Ville :',
                    'class' => City::class,
                    'choice_label' => 'cityName',
                    'required' => 'false',
                    'placeholder' => 'Choisir une ville',
                    'mapped' => false,

                ])

                    ->add('location', EntityType::class, [
                        'label' => 'Lieu :',
                        'class' => Location::class,
                        'choice_label' => 'locationName',
                        'placeholder' => 'Choisir un lieu',
                        'required' => false,

                    ]);
            }
            if ($entity->getLocation() != null){
                $builder->add('city', EntityType::class, [
                    'label' => 'Ville :',
                    'class' => City::class,
                    'choice_label' => 'cityName',
                    'required' => false,
                    'placeholder' => 'Choisir une ville',
                    'mapped' => false,
                    'data'=>$entity->getLocation()->getCity()
                ])

                    ->add('location', EntityType::class, [
                        'label' => 'Lieu :',
                        'class' => Location::class,
                        'choice_label' => 'locationName',
                        'placeholder' => 'Choisir un lieu',
                        'required' => false,
                        'data'=>$entity->getLocation()
                    ]);
            }






                ;


         }

        }


    public function configureOptions(OptionsResolver $resolver): void{
        $resolver->setDefaults([
            'data_class' => Activity::class,
            'cancel_mode' => false,]);
    }
  
  
}

