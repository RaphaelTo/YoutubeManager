<?php

namespace App\Controller;

use App\Entity\Video;
use App\Form\AddVideoType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class VideoController extends AbstractController
{
    /**
     * @Route("/Addvideo", name="addVideo")
     */
    public function addVideo(Request $request)
    {
        $video = new Video();
        $form = $this->createForm(AddVideoType::class, $video);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($video);
            $em->flush();

            return $this->redirectToRoute('home');
        }
        return $this->render('video/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
