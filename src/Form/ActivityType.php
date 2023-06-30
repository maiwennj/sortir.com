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
use Symfony\Component\Form\Extension\Core\Type\DateIntervalType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use function Symfony\Component\Clock\now;

class ActivityType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options): void{

        if ($options['cancel_mode'] === true) {
            $builder->add('cancellationReason', TextareaType::class, [
                'label' => 'Motif d\'annulation',
                'required' => true,
            ]);
        }
      
        if ($options['cancel_mode'] === false) {
          $builder
            ->add('activityName',null,[
              'label' => 'Nom de la sortie :'])

            ->add('startDate',null,[
              'label'=>'Date et heure de la sortie :',
              'widget' => 'single_text'])

            ->add('closingDate',DateType::class,[
                'label'=>"Date limite d'inscription :",
                'widget' => 'single_text'])

            ->add('maxRegistration',null,[
              'label'=>'Nombre de places :'])

            ->add('duration',null,[
              'label'=>'Durée :'])

            ->add('description',null,[
              'label'=>'Description et infos :'])

//            ->add('pictureUrl',FileType::class,[
//             'label'=>'Ajouter une image (fichier image)'])
              
            ->add('location',EntityType::class,[
              'label' => 'Lieu :',
              'class' => Location::class,
              'choice_label' => 'locationName'])
            
            ->add('site',EntityType::class,[
              'label' => 'Campus :',
              'class' => Site::class,
              'choice_label' => 'siteName'])
            
            ->add('city',EntityType::class,[
              'label' => 'Ville :',
              'class' => City::class,
              'choice_label' => 'cityName',
              'mapped' => false]);
        }
    }  

    public function configureOptions(OptionsResolver $resolver): void{
        $resolver->setDefaults([
            'data_class' => Activity::class,
            'cancel_mode' => false,]);
    }
  
  
}
