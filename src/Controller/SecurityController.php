<?php

namespace App\Controller;

use App\Form\LoginUserType;
use App\Form\ProfileUserType;
use App\Repository\UserRepository;
use App\Repository\VideoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;
use App\Form\RegisterUserType;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/register", name="Register")
     */
    public function addUser(Request $request,UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = new User();
        $form= $this->createForm(RegisterUserType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $password= $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);

            $entityManager=$this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute('home');
        }

        return $this->render('register/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/login", name="login")
     */
    public function login(AuthenticationUtils $authenticationUtils){
        $user = new User();
        $form=$this->createForm(LoginUserType::class, $user);

        return $this->render('security/login.html.twig', [
            'error'=> $authenticationUtils->getLastAuthenticationError(),
            'form'=> $form->createView()
        ]);

    }

    /**
     * @Route("/profile/{id}", name="profileId")
     */
    public function viewProfile(int $id, UserRepository $userRepository){
        $user = $userRepository->find($id);
        return $this->render('profile/profile.html.twig', [
            'user'=>$user
        ]);
    }

    /**
     * @Route("/profile", name="myProfile")
     */
    public function myProfile(Request $request, EntityManagerInterface $entityManager){
        $user = $this->getUser();
        $form = $this->createForm(ProfileUserType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute('home');
        }
        return $this->render('profile/myProfile.html.twig', [
           'form'=> $form->createView()
        ]);
    }

    /**
     * @Route("/admin", name="allUser")
     */
    public function allUser(UserRepository $userRepository, VideoRepository $videoRepository){
        $user = $userRepository->findAll();
        $video = $videoRepository->findAll();
        return $this->render('admin/allUser.html.twig', [
           'user' => $user,
            'video'=>$video
        ]);
    }
}
