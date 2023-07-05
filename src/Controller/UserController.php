<?php

namespace App\Controller;

use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
#[Route('/user', name: 'user_')]
class UserController extends AbstractController{

    #[Route(path: '/profile/{id}', name: 'profile',requirements: ['id'=>'\d+'])]
    public function profile(UserRepository $userRepository, $id): Response{
        $user = $userRepository->find($id);
        return $this->render('user/details.html.twig',
            ['user' => $user]);
    }

    #[Route(path: '/my_profile', name: 'my_profile')]
    public function myProfile(UserRepository $userRepository, ): Response{
        $user = $userRepository->find($this->getUser()->getId());
        return $this->render('user/my-profile.html.twig',
            ['user' => $user]);
    }

    #[Route(path: '/my_profile_update', name: 'my_profile_update')]
    public function update(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordHasher): Response{
        $user = $this->getUser();
        $formUser = $this->createForm(UserType::class,$user,['admin-mode'=>false]);
        $formUser->handleRequest($request);

        if ($formUser->isSubmitted() && $formUser->isValid()){
            try {
                $file = $formUser->get('userProfile')->get('pictureFile')->getData();
                if($file!==null){
                    //create and add file
                    $extension = $file->guessExtension();
                    $userId = $user->getId();
                    $fileName = rand(1, 99999).'-'.$userId.'.'.$extension;
                    dump($fileName);
                    $file->move('assets\img\userImg',$fileName);

                    //delete old img file if existing
                    $existantImgName = $user->getUserProfile()->getPictureUrl();
                    if ($existantImgName!==null){
                        $existanteFile = 'assets\img\userImg'.'/'.$existantImgName;
                        dump($existanteFile);
                        if($existanteFile!==null){
                            if(file_exists($existanteFile)){
                                dump($existanteFile);
                                unlink($existanteFile);
                            }
                        }
                    }

                    $userProfile = $user->getUserProfile();
                    $userProfile->setPictureUrl($fileName);
                    $user->setUserProfile($userProfile);
                }
                $entityManager->persist($user);
                $entityManager->flush();

                $this->addFlash('success','Modifications validées');
                return $this->redirectToRoute('user_my_profile');
            }catch (Exception $exception){
                $this->addFlash('danger','Modifications ratées');
            }
        }

        return $this->render('user/my-profile-update.html.twig',[
            'formUser' => $formUser->createView(),
        ]);
    }




}
