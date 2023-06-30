<?php

namespace App\Controller;

use App\Entity\Activity;
use App\Entity\Location;
use App\Entity\Registration;
use App\Entity\State;
use App\Form\ActivityType;
use App\Form\FilterType;
use App\Form\LocationFormType;
use App\Model\Filter;
use App\Repository\ActivityRepository;
use App\Repository\RegistrationRepository;
use App\Repository\StateRepository;
use App\Repository\UserProfileRepository;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Util\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use function Symfony\Component\Clock\now;

#[IsGranted('ROLE_USER')]
#[Route('/activity', name: 'activity_')]

class ActivityController extends AbstractController
{

    /**---------------Location--------------**/
    #[Route('/location/create', name: 'location_create')]
    public function createLocation(EntityManagerInterface $entityManager,Request $request): Response
    {
        $location = new Location();
        $locationForm=$this->createForm(LocationFormType::class,$location);
        $locationForm->handleRequest($request);

        if ($locationForm->isSubmitted() && $locationForm->isValid()) {
            try {
                $entityManager->persist($location);
                $entityManager->flush();
                $this->addFlash('success', 'Lieu ajouté avec succès.');
                return $this->redirectToRoute('activity_create');
            }catch (\Exception $exception){
                $this->addFlash('danger','Ajout impossible');
            }
        }
        return $this->render('activity/location-create.html.twig', [
            'locationForm'=>$locationForm->createView()
        ]);

    }
    /**---------------Activity--------------**/

    #[Route('/create', name: 'create')]
    public function create(EntityManagerInterface $entityManager,Request $request,StateRepository $stateRepository,UserProfileRepository $userProfileRepository): Response{

        $activity = new Activity();
        $activity->setStartDate(now()->modify('+1 day'));
        $activity->setClosingDate(now()->modify('2 hours'));
        $activityForm = $this->createForm(ActivityType::class, $activity);
        $activityForm->handleRequest($request);

        if($activityForm->isSubmitted() && $activityForm->isValid()){
            try{

                $btn = $request->get('btnActivity');
                if($btn == 'save'){
                    //save if save btn
                    $state = $stateRepository->find(1);
                    $flashMessage = "L'activité a bien été enregistrée";

                }elseif($btn == 'add'){
                    //add if add btn
                    $state = $stateRepository->find(2);
                    $flashMessage = "L'activité a bien été créée";
                }else{
                    //redirect if problem
                    $this->addFlash('danger',"Un problème est survenu");
                    return $this->redirectToRoute('activity_create',);
                }

                $activity->setState($state);
                $activity->setOrganiser($this->getUser()->getUserProfile());
                $entityManager->persist($activity);
                $entityManager->flush();

                $this->addFlash('success', $flashMessage );
                return $this->redirectToRoute('activity_details', ["id" => $activity->getId()]);

            } catch (Exception $exception) {
                $this->addFlash('danger', "L'activité n'a pas été ajouté.");
                return $this->redirectToRoute('activity_create');
            }
        }

        return $this->render('activity/create.html.twig', [
            'form' => $activityForm->createView()
        ]);
    }


    #[Route('/', name: 'list')]
    public function list(
        ActivityRepository     $activityRepository,
        RegistrationRepository $registrationRepository,
        Request                $request,
        FormFactoryInterface   $formFactory
    ): Response
    {
        $filter = new Filter();

        $form = $formFactory->create(FilterType::class, $filter);
        $form->handleRequest($request);
      
        $userProfile = $this->getUser()->getUserProfile();
        $registrations = $userProfile->getRegistrations();
        $activitiesIds = [];
        foreach ($registrations as $registration ){
            $activityId = $registration->getActivity()->getId();
            $activitiesIds[] = $activityId;
        }

        $activities = $activityRepository->getFilteredActivities($filter,$userProfile,$activitiesIds);

        return $this->render('activity/list.html.twig', [
            'activities' => $activities,
            "form" => $form->createView()

        ]);
    }


    #[Route('/{id}', name: 'details', requirements: ["id" => "\d+"])]
    public function details($id, ActivityRepository $activityRepository): Response
    {
        $activity = $activityRepository->find($id);
        if (!$activity) {
            return $this->redirectToRoute('activity_list');
        }
        return $this->render('activity/detail.html.twig', [
            'activity' => $activity
        ]);
    }

    #[Route('/update/{id}', name: 'update',requirements: ['id'=>'\d+'])]
    public function update( EntityManagerInterface $entityManager, int $id,ActivityRepository $activityRepository,StateRepository $stateRepository, Request $request)
    {
        $activity = $activityRepository->find($id);
        $user = $this->getUser()->getUserProfile();

        /**
         * check if user is the organiser
         */
        if($activity->getOrganiser()==$user){

            $activityForm = $this->createForm(ActivityType::class, $activity);
            $activityForm->handleRequest($request);

            if($activityForm->isSubmitted() && $activityForm->isValid()){
                try{
                    $btn = $request->get('btnActivity');
                    if($btn == 'save'){
                        //save if save btn
                        $state = $stateRepository->find(1);
                        $flashMessage = "L'activité a bien été enregistrée et mis à jour";

                    }elseif($btn == 'add'){
                        //add if add btn
                        $state = $stateRepository->find(2);
                        $flashMessage = "L'activité a bien été validé et mis à jour";
                    }else{
                        //redirect if problem
                        $this->addFlash('danger',"Un problème est survenu");
                        return $this->redirectToRoute('activity_update',["id" => $activity->getId()]);
                    }
                    $activity->setState($state);
                    $activity->setOrganiser($this->getUser()->getUserProfile());
                    $entityManager->persist($activity);
                    $entityManager->flush();
                    $this->addFlash('success', $flashMessage );
                    if($btn == 'save'){
                        return $this->redirectToRoute('activity_update',["id" => $activity->getId()]);
                    }else{
                        return $this->redirectToRoute('activity_details',["id" => $activity->getId()]);
                    }

                } catch (Exception $exception) {
                    $this->addFlash('danger', "L'activité n'a pas été modifiée.");
                    return $this->redirectToRoute('activity_update',["id" => $activity->getId()]);
                }
            }

            return $this->render('activity/create.html.twig', [
                'form' => $activityForm->createView(),
            ]);

        }else{
            $this->addFlash('danger', "Vous ne pouvez pas modifier cette activité");
            return $this->redirectToRoute('activity_list');
        }


    }






    #[Route('/cancel/{id}', name: 'cancel',requirements: ['id'=>'\d+'])]
    public function cancel( EntityManagerInterface $entityManager, int $id,ActivityRepository $activityRepository,Request $request): Response
    {
        $activity = $activityRepository->find($id);
        $currentUser = $this->getUser()->getUserProfile();
        $organiser = $activity->getOrganiser();
        $currentState = $activity->getState()->getId();

        if ($currentUser === $organiser ) {
            if($currentState === 2 || $currentState === 3) {

                $activityForm = $this->createForm(ActivityType::class, $activity, ['cancel_mode' => true]);
                $activityForm->handleRequest($request);
                $cancelStateId = 6;

                if ($activityForm->isSubmitted() && $activityForm->isValid()) {

                    try {
                        $cancelState = $entityManager->getReference(State::class, $cancelStateId);
                        $activity->setState($cancelState);
                        $cancelState = $entityManager->getReference(State::class, $cancelStateId);
                        $activity->setState($cancelState);
                        $entityManager->persist($activity);
                        $entityManager->flush();

                        $this->addFlash('success', "L'activité a été annulée avec succès.");
                        return $this->redirectToRoute("activity_list");
                    } catch
                    (\Exception $exception) {
                        $this->addFlash('danger', "Erreur d'annulation");
                        return $this->redirectToRoute("activity_cancel", ['id' => $activity->getId()]);
                    }

                }

                return $this->render('activity/cancel.html.twig', ["activity" => $activity, "form" => $activityForm->createView()]);
            }else{
                $this->addFlash('danger','erreur état');
            }
        } else {
            $this->addFlash('danger', "Vous n'êtes pas autorisé à annuler cette activité.");
            return $this->redirectToRoute("activity_list");
        }
        return $this->redirectToRoute("activity_list");
    }

    #[Route('/register/{id}', name: 'register')]
    public function register(EntityManagerInterface $entityManager, Request $request, int $id): Response
    {
        $activity = $entityManager->getRepository(Activity::class)->find($id);
        $currentState = $activity->getState()->getId();

        if ($currentState === 2) {
            try {
                $registration = new Registration();
                $registration->setParticipant($this->getUser()->getUserProfile());
                $registration->setActivity($activity);
                $registration->setRegistrationDate(now());
                $activity->addRegistration($registration);

                $entityManager->persist($registration);
                $entityManager->persist($activity);
                $entityManager->flush();

                $this->addFlash('success', "Vous avez été inscrit à cette activité avec succès.");
                return $this->redirectToRoute('activity_list');
            } catch (\Exception $exception) {
                $this->addFlash('danger', "Nous n'avons pas pu vous inscrire à cette activité.");
            }

            return $this->redirectToRoute('activity_list');
        } else {
            $this->addFlash('danger', "Nous n'avons pas pu vous inscrire à cette activité.");
        }

        return $this->redirectToRoute('activity_list');
    }
    #[Route('/quit/{id}',name:'quit')]
    public function quit(EntityManagerInterface $entityManager, Request $request, int $id): Response
    {
        try {
            $activity = $entityManager->getRepository(Activity::class)->find($id);
            $userProfile = $this->getUser()->getUserProfile();

            $registration = $entityManager->getRepository(Registration::class)->findOneBy([
                'activity' => $activity,
                'participant' => $userProfile,
            ]);

            if ($registration) {
                $activity->removeRegistration($registration);
                $entityManager->remove($registration);
                $entityManager->flush();
                $this->addFlash('success', "Vous avez été désinscrit de cette activité avec succès.");
            } else {
                $this->addFlash('danger', "Vous n'êtes pas inscrit à cette activité.");
            }
        } catch (\Exception $exception) {
            $this->addFlash('danger', "Nous n'avons pas pu vous désinscrire de cette activité : " . $exception->getMessage());
        }

        return $this->redirectToRoute('activity_list');
    }
}


