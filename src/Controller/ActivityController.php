<?php

namespace App\Controller;

use App\Entity\Activity;
use App\Entity\Registration;
use App\Form\ActivityType;
use App\Form\FilterType;
use App\Model\Filter;
use App\Repository\ActivityRepository;
use App\Repository\RegistrationRepository;
use App\Repository\StateRepository;
use App\Repository\UserProfileRepository;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\This;
use PHPUnit\Util\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
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
    #[Route('/create', name: 'create')]
    public function create(
        EntityManagerInterface $entityManager,
        Request                $request,
        StateRepository        $stateRepository,
        UserProfileRepository  $userProfileRepository
    ): Response
    {

        $activity = new Activity();
        $activityForm = $this->createForm(ActivityType::class, $activity);

        $activityForm->handleRequest($request);

        if ($activityForm->isSubmitted() && $activityForm->isValid()) {
            try {
                //à modifier pour fonctionner avec le changement de stade et la bdd

        if($activityForm->isSubmitted() && $activityForm->isValid()){
            try{

                $state = $stateRepository->find(1);

                $activity->setState($state);

                $activity->setOrganiser($this->getUser()->getUserProfile());

                $entityManager->persist($activity);
                $entityManager->flush();
                $this->addFlash('success', "L'activité a bien été créée");
                $this->redirectToRoute('activity_details', ["id" => $activity->getId()]);
            } catch (Exception $exception) {
                $this->addFlash('danger', "Le souhait n'a pas été ajouté.");
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

        $activities = $activityRepository->getFilteredActivities($filter, $this->getUser()->getUserProfile());


        return $this->render('activity/list.html.twig', [
            'activities' => $activities,
            "form" => $form->createView()

        ]);
    }


    #[Route('/{id}',
        name: 'details',
        requirements: ["id" => "\d+"]
    )]
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

    #[Route('/update', name: 'update')]
    public function update()
    {

    }

    #[Route('/cancel/{id}', name: 'cancel',requirements: ['id'=>'\d+'])]

    public function cancel( EntityManagerInterface $entityManager, int $id,ActivityRepository $activityRepository,Request $request): Response
    {
        $activity = $activityRepository->find($id);
        $reason = $request->request->get('reason');
       // dd($request->request->get('reason'));
        if ($reason){
            try {
        $entityManager->remove($activity);
        $entityManager->flush();

        $this->addFlash('success', "L'activité a été annulée avec succès.");

         }catch (\Exception $exception){
            $this->addFlash('danger',"Erreur d'annulation");
            return $this->redirectToRoute("activity_cancel",['id'=>$activity->getId()]);
        }
        }

        return $this->render('activity/cancel.html.twig',["activity"=>$activity]);
    }


    #[Route('/register/{id}',name:'register')]
    public function register(EntityManagerInterface $entityManager,Request $request,int $id): Response{
        try {
            $activity = $entityManager->getRepository(Activity::class)->find($id);
            $registration = new Registration();

            $registration->setParticipant($this->getUser()->getUserProfile());
            $registration->setActivity($activity);
            $registration->setRegistrationDate(now());
            $activity->addRegistration($registration);

            $entityManager->persist($registration);
            $entityManager->persist($activity);
            $entityManager->flush();

            return $this->redirectToRoute('activity_list');
        }catch (\Exception $exception){
            $this->addFlash('danger',"Nous n'avons pas pu vous inscrire à cette activité.");
            return $this->redirectToRoute('activity_list');
        }
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


