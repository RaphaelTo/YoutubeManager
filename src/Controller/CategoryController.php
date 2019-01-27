<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Video;
use App\Form\CategoryAddType;
use App\Form\UpdateCategoryType;
use App\Repository\CategoryRepository;
use App\Repository\VideoRepository;
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
     * @Route("/category/{id}", name="categoryId")
     */
    public function categoryby(int $id, VideoRepository $videoRepository)
    {
        $cat = $videoRepository->findBy(['category'=>$id]);
        return $this->render('category/category.html.twig',[
            'cat'=> $cat
        ]);
    }

    /**
     * @Route("category/update/{id}", name="categoryUpdate")
     */
    public function updateCategories(int $id, Request $request, EntityManagerInterface $entityManager, CategoryRepository $categoryRepository){
        $cat = $categoryRepository->find($id);

        $form = $this->createForm(UpdateCategoryType::class, $cat);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($cat);
            $entityManager->flush();
            return $this->redirectToRoute('detailCategory');
        }
        return $this->render('category/updateCategory.html.twig', [
            'form'=> $form->createView()
        ]);

    }

    /**
     * @Route("category/delete/{id}", name="categoryDelete")
     */
    public function deleteVideo(Category $category, EntityManagerInterface $entityManager){
        $video = new Video();
        $objet = $video->getCategory();

        $entityManager->remove($category);
        $entityManager->flush();

        return $this->redirectToRoute('detailCategory');
    }


}
