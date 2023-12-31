<?php

namespace App\Controller;

use App\Entity\Activity;
use App\Entity\Location;
use App\Entity\Registration;
use App\Form\ActivityType;
use App\Form\FilterType;
use App\Form\LocationFormType;
use App\Model\Filter;
use App\Repository\ActivityRepository;
use App\Repository\LocationRepository;
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


    public function create(EntityManagerInterface $entityManager,Request $request,StateRepository $stateRepository,UserProfileRepository $userProfileRepository,LocationRepository $locationRepository): Response{
        $locations=$locationRepository->findAll();



        $activity = new Activity();
        $activity->setStartDate(now()->modify('+3 days'));
        $activity->setClosingDate(now()->modify('tomorrow'));
        $activityForm = $this->createForm(ActivityType::class, $activity);
        $activityForm->handleRequest($request);
        $locations = $locationRepository->findAll();

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
            'form' => $activityForm->createView(),
            'activity'=>$activity,

            'locations'=> $locations,
            'page_title'=> 'Créer une sortie'


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

        //unset activity if in creation and not organise by user connected
        for($i = 0 ; $i<count($activities); $i++){
            if($activities[$i]->getState()->getId() === 1 && $activities[$i]->getOrganiser()->getId() != $userProfile->getId()){
                unset($activities[$i]);
            }
        }

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
    public function update( ActivityRepository $activityRepository,
                            EntityManagerInterface $entityManager,
                            StateRepository $stateRepository,
                            LocationRepository $locationRepository,
                            Request $request,
                            int $id)
    {
        $activity = $activityRepository->find($id);
        $user = $this->getUser()->getUserProfile();
        $locations = $locationRepository->findAll();
        //check if user is the organiser
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
                    return $this->redirectToRoute('activity_update',["id" => $activity->getId(),'activity'=>$activity]);
                }
            }

            return $this->render('activity/create.html.twig', [
                'form' => $activityForm->createView(),
                'activity'=> $activity,
                'locations'=> $locations,
                'page_title'=>'Modifier une sortie'
            ]);

        }else{
            $this->addFlash('danger', "Vous ne pouvez pas modifier cette activité");
            return $this->redirectToRoute('activity_list');

        }


    }


    #[Route('/delete/{id}',name: 'delete' ,requirements: ['id'=>'\d+'])]
    public function delete(EntityManagerInterface $entityManager,ActivityRepository $activityRepository, int $id)
    {
        $userProfile = $this->getUser()->getUserProfile();
        $activity = $activityRepository->find($id);
        $activityOrganiser = $activity->getOrganiser();

        if($userProfile===$activityOrganiser){
            if($activity->getState()->getId()===1){
                try {
                    $entityManager->remove($activity);
                    $entityManager->flush();

                    $this->addFlash('success',"L'activité a bien été supprimée");
                    $this->redirectToRoute('activity_list');
                }catch (Exception $exception){
                    $this->addFlash('danger', "L'activité n'a pas été supprimée.");
                    return $this->redirectToRoute('activity_update',["id" => $activity->getId()]);
                }
            }else{
                $this->addFlash('danger',"L'état de cette activité ne lui permet pas d'être supprimmée");
            }
        }else{
            $this->addFlash('danger',"Vous n'avez pas le droit de supprimer cette activité");
        }
        return $this->redirectToRoute('activity_list');



    }

    #[Route('/cancel/{id}', name: 'cancel',requirements: ['id'=>'\d+'])]
    public function cancel(ActivityRepository $activityRepository,
                           EntityManagerInterface $entityManager,
                           StateRepository $stateRepository,
                           Request $request,
                           int $id): Response
    {
        $activity = $activityRepository->find($id);
        $currentUser = $this->getUser()->getUserProfile();
        $organiser = $activity->getOrganiser();
        $currentState = $activity->getState()->getId();
        $referer = $request->headers->get('referer');
        if ($currentUser === $organiser ) {
            if($currentState === 2 || $currentState === 3) {

                $activityForm = $this->createForm(ActivityType::class, $activity, ['cancel_mode' => true]);
                $activityForm->handleRequest($request);

                if ($activityForm->isSubmitted()) {
                    try {
                        $cancelStateId = 6;
                        $cancelState = $stateRepository->find($cancelStateId);
                        $activity->setState($cancelState);
                        $entityManager->persist($activity);
                        $entityManager->flush();
                        $this->addFlash('success', "L'activité a été annulée avec succès.");
                        return $this->redirectToRoute("activity_list");
                    } catch
                    (Exception $exception) {
                        $this->addFlash('danger', "Erreur d'annulation");
                        return $this->redirectToRoute("activity_cancel", ['id' => $activity->getId()]);
                    }

                }
                return $this->render('activity/cancel.html.twig', [
                    'activity' => $activity,
                    'form' => $activityForm->createView(),
                    'referer' => $referer]);
            }else{
                $this->addFlash('danger',"L'état de cette activité ne lui permet pas d'être annulée");
            }
        } else {

            $this->addFlash('danger', "Vous n'êtes pas autorisé à annuler cette activité.");
            return $this->redirectToRoute("activity_list");
        }
        return $this->redirectToRoute("activity_list");
    }

    #[Route('/participate/{id}', name: 'participate')]
    public function participate(EntityManagerInterface $entityManager, Request $request, int $id, StateRepository $stateRepository): Response
    {
        $activity = $entityManager->getRepository(Activity::class)->find($id);
        $currentState = $activity->getState()->getId();
        $referer = $request->headers->get('referer');
        //check if current activity state is 'open'
        if ($currentState === 2) {
            $regMax = $activity->getMaxRegistration();
            $regNumber = count($activity->getRegistrations());

            //check if there are still places for this activity
            if($regNumber<$regMax){
                try {
                    $registration = new Registration();
                    $registration->setParticipant($this->getUser()->getUserProfile());
                    $registration->setActivity($activity);
                    $registration->setRegistrationDate(now());
                    $activity->addRegistration($registration);

                    if ($activity->getMaxRegistration() == count($activity->getRegistrations())){
                        $activity->setState($stateRepository->find(3));
                    }

                    $entityManager->persist($registration);
                    $entityManager->persist($activity);
                    $entityManager->flush();

                    $this->addFlash('success', "Vous avez été inscrit à cette activité avec succès.");
                    return $this->redirect($referer);

                } catch (\Exception $exception) {
                    $this->addFlash('danger', "Nous n'avons pas pu vous inscrire à cette activité.");
                }
                return $this->redirectToRoute('activity_list');
            }else{
                $this->addFlash('danger', "Il n'y a plus de place disponible pour cette activité.");
            }
        } else {
            $this->addFlash('danger', "Nous n'avons pas pu vous inscrire à cette activité.");
        }
        return $this->redirectToRoute('activity_list');
    }

    #[Route('/quit/{id}',name:'quit')]
    public function quit(EntityManagerInterface $entityManager,ActivityRepository $activityRepository,RegistrationRepository $registrationRepository,
                         StateRepository $stateRepository,int $id,Request $request): Response{
        $referer = $request->headers->get('referer');
        try {
            // getting the activity, the user and a registration, if it exists for this user in this activity
            $activity = $activityRepository->find($id);
            $participant = $this->getUser()->getUserProfile();
            $registration = $registrationRepository->findOneBy(['activity' => $activity,'participant' => $participant]);

            /**
             * If there IS a participation, AND if the date of the day is INFERIOR to the activity date
             * --> 1. we can remove the participation
             * --> 2. if the date of the day is INFERIOR to the closing date, then the activity is set back to "ouvert"
             */
            if ($registration) {
                /**
                 * Check : has the activity already begun ?
                 */
                if ($activity->getStartDate()>now()){
                    $activity->removeRegistration($registration);
                    if ($activity->getMaxRegistration() > count($activity->getRegistrations())) {
                        $activity->setState($stateRepository->find(2));
                    }
                    $entityManager->persist($activity);
                    $entityManager->flush();
                    $this->addFlash('success', "Vous avez été désinscrit de cette activité avec succès.");
                }else{
                    // ERROR MESSAGE if the activity has already beguns
                    $this->addFlash('danger', "L'activité est déjà commencée, vous ne pouvez pas vous en désinscrire.");
                }
            } else {
                // ERROR MESSAGE if the user isn't participating
                $this->addFlash('danger', "Vous n'êtes pas inscrit à cette activité.");
            }
        } catch (\Exception $exception) {
            $this->addFlash('danger', "Nous n'avons pas pu vous désinscrire de cette activité : " . $exception->getMessage());
        }
        return $this->redirect($referer);
    }
}


