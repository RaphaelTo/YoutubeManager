<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\VideoRepository;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(VideoRepository $videoRepository)
    {
        $video = $videoRepository->findAll();

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'video' => $video,
        ]);
    }

    /**
     * @Route("/video/{id}", name="detailVideo")
     */
    public function videoDetail(int $id, VideoRepository $videoRepository){
        $video = $videoRepository->find($id);
        return $this->render('home/detailVideo.html.twig', [
            'video'=>$video
        ]);
    }
}
