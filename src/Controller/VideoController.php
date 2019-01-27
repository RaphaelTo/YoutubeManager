<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Video;
use App\Form\AddVideoType;
use App\Form\UpdateVideoType;
use App\Repository\VideoRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class VideoController extends AbstractController
{
    /**
     * @Route("/Addvideo", name="addVideo")
     */
    public function addVideo(Request $request, LoggerInterface $logger)
    {

        $video = new Video();
        $form = $this->createForm(AddVideoType::class, $video);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($video);
            $em->flush();
            $this->addFlash('notice', 'has been created');
            $logger->info("A video has been added by");
            return $this->redirectToRoute('home');
        }
        return $this->render('video/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/myvideo", name="myVideo")
     */
    public function myVideo(Security $security, VideoRepository $videoRepository)
    {

        if($security->getToken()->getUser()->getRoles()[0] == "ROLE_ADMIN"){
            $video = $videoRepository->findAll();
        }else{
            $getuser = $security->getToken()->getUser()->getId();
            $video = $videoRepository->findBy(['user'=>$getuser]);
        }

        return $this->render('video/myVideo.html.twig', [
            'videoUser'=>$video,
        ]);
    }

    /**
     * @Route("/update/{id}", name="updateVideo")
     */
    public function updateVideo(int $id, Request $request, EntityManagerInterface $entityManager, VideoRepository $videoRepository, LoggerInterface $logger){

        $video = $videoRepository->find($id);
        $form = $this->createForm(UpdateVideoType::class, $video);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $video = $form->getData();
            $entityManager->persist($video);
            $entityManager->flush();
            $this->addFlash('notice', 'Your modification has been changed');
            $logger->info('A video has been changed ');
           return $this->redirectToRoute('home');
        }
        return $this->render('video/update.html.twig', [
            'form'=>$form->createView()
        ]);
    }

    /**
     * @Route("/delete/{id}", name="deleteVideo")
     * @ParamConverter("video", options={"mapping"={"id"="id"}})
     */
    public function deleteVideo(Video $video, EntityManagerInterface $entityManager, LoggerInterface $logger){
        $entityManager->remove($video);
        $entityManager->flush();
        $this->addFlash('notice', 'has been deleted');
        $logger->info('A video has been delete ');
        return $this->redirectToRoute('home');
    }
}
