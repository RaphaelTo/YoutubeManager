<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Video;
use App\Form\CategoryAddType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    /**
     * @Route("/category", name="category")
     */
    public function index(CategoryRepository $categoryRepository)
    {
        $cat = $categoryRepository->findAll();

        return $this->render('category/index.html.twig', [
            'controller_name' => 'CategoryController',
            'categorie' => $cat
        ]);
    }

    /**
     * @Route("/category/add", name="addCategory")
     */
    public function addCategory(Request $request, EntityManagerInterface $entityManager){
        $cat = new Category();
        $form = $this->createForm(CategoryAddType::class, $cat);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($cat);
            $entityManager->flush();

            return $this->redirectToRoute('detailCategory');
        }
        return $this->render('category/add.html.twig', [
            'form'=> $form->createView()
        ]);
    }

    /**
     * @Route("/categorydetail", name="detailCategory")
     */
    public function detailCategory(CategoryRepository $categoryRepository){
        $cat = $categoryRepository->findAll();
        return $this->render('category/detailCategory.html.twig', [
            'cat'=>$cat
        ]);
    }

    /**
     * @Route("/category/{category}", name="categoryId")
     * @ParamConverter("video", options={"mapping"={"category"="category"}})
     */
    public function categoryby(Video $video)
    {
        return $this->render('category/category.html.twig',[
            'cat'=> $video
        ]);
    }

}
