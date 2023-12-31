<?php

namespace App\Controller;

use App\Entity\Location;
use App\Entity\Site;
use App\Entity\User;
use App\Entity\UserProfile;
use App\Form\LocationFormType;
use App\Form\SiteType;
use App\Form\UserImportType;
use App\Form\UserType;
use App\Repository\SiteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
#[Route('/admin',name: 'admin_')]
class AdminController extends AbstractController
{
    #[Route('/', name: 'hub')]
    public function adminHub(): Response{
        return $this->render('admin/index.html.twig');
    }

    #[Route('/presentation', name: 'presentation')]
    public function presentation(): Response{
        return $this->render('admin/presentation.html.twig');
    }

    #[Route('/site/create', name: 'site_create')]
    public function create(EntityManagerInterface $entityManager,Request $request): Response
    {
        $site = new Site();
        $form = $this->createForm(SiteType::class,$site);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            try {
                $entityManager->persist($site);
                $entityManager->flush();
                $this->addFlash('success', 'Site ajouté avec succès.');
                return $this->redirectToRoute('activity_list');
            }catch (\Exception $exception){
                $this->addFlash('danger','Ajout impossible');
            }
        }
        return $this->render('admin/site-create.html.twig',[
            'form'=>$form->createView()
        ]);
    }

    #[Route('/user-creation', name: 'user_create')]
    public function addUser(Request $request,EntityManagerInterface $entityManager,UserPasswordHasherInterface $userPasswordHasher){

        $user = new User();
        $userProfile = new UserProfile();
        $form = $this->createForm(UserType::class,$user,['admin-mode'=>true]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            try {

                if ($user->getIsAdmin()){
                    $user->setRoles(["ROLE_ADMIN"]);
                }else{
                    $user->setRoles(["ROLE_USER"]);
                }

                $user->setPassword( $userPasswordHasher->hashPassword($user, $user->getUsername()));
                $userProfile= $user->getUserProfile();
                $user->setUserProfile($userProfile);
                $entityManager->persist($user);
                $entityManager->flush();
                $username = $user->getUsername();
                $this->addFlash('success',"L'utilisateur $username a bien été créé.");
                return $this->redirectToRoute('admin_hub');
            }catch (\Exception $exception){
                $this->addFlash('danger',"L'utilisateur n'a pas pu être ajouté.");
            }
        }

        return $this->render('admin/user-create.html.twig',[
            'form'=>$form
        ]);

    }
    #[Route('/user-import', name: 'user_import')]
    public function importUser(Request $request,SiteRepository $siteRepository, EntityManagerInterface $entityManager,UserPasswordHasherInterface $userPasswordHasher){

        $form = $this->createForm(UserImportType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            try {
                //********** Handling the file extension
                $file = $form['attachment']->getData();
                $extension = $file->guessExtension();
                if (!$extension) {
                    $extension = 'bin';
                }
                $fileName = rand(1, 99999).'.'.$extension;
                $file->move("./uploaded_files", $fileName);
                //********** end of dealing with the file

                $importFile = file_get_contents('uploaded_files/'.$fileName);
                $importFile = str_replace("\u{FEFF}","",$importFile);
                $importFileLines = explode("\r\n",$importFile);
                array_pop($importFileLines);

                for ($index=0;$index<count($importFileLines);$index++){
                    $importFileLines[$index] = explode(";",$importFileLines[$index]);
                }
                $compteur=0;
                foreach ($importFileLines as list($username,$isAdmin,$isActive,$firstName,$lastName,$site,$phoneNumber,$emailAdress)){
                    $newUserProfile = new UserProfile();
                    $newUserProfile->setFirstName($firstName);
                    $newUserProfile->setLastName($lastName);
                    $newUserProfile->setSite($siteRepository->find($site));
                    $newUserProfile->setPhoneNumber($phoneNumber);
                    $newUserProfile->setEmailAdress($emailAdress);

                    $newUser = new User();
                    $newUser->setUserProfile($newUserProfile);
                    $newUser->setUsername($username);
                    if ($isAdmin){
                        $newUser->setRoles(["ROLE_USER","ROLE_ADMIN"]);
                        $newUser->setIsAdmin(1);
                    }else{
                        $newUser->setRoles(["ROLE_USER"]);
                        $newUser->setIsAdmin(0);
                    }
                    $newUser->setIsActive($isActive);
                    $newUser->setPassword( $userPasswordHasher->hashPassword($newUser,$username));

                    $newUserProfile->setUser($newUser);
                    $entityManager->persist($newUser);
                    $entityManager->persist($newUserProfile);
                    $compteur++;
                }
                $entityManager->flush();


                $this->addFlash('success',"$compteur utilisateur(s) inséré(s) avec succès.");

                $filesystem = new Filesystem();
                $filesystem->remove("./uploaded_files", $fileName);

                return $this->redirectToRoute('admin_user_import');
            }catch (\Exception $exception){
                $this->addFlash('danger',"Impossible d'insérer le fichier d'utilisateurs.");
            }
        }

        return $this->render('admin/user-import.html.twig',[
            'form'=>$form]);
    }

}
