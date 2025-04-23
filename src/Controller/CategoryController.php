<?php

namespace App\Controller;

use App\Entity\Category;
use App\Service\CategoryService;
use App\Form\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class CategoryController extends AbstractController
{
    public function __construct(
        // importer une classe en lecture seule (private readonly)
        private readonly CategoryService $categoryService
    )
    {}

    #[Route('/categories', name: 'app_category_all')]
    public function showAll(): Response
    {
        try {
            $categories = $this->categoryService->getAllCategories();
        } catch (\Exception $e) {
            $categories = null;
        }
        
        return $this->render('category/categories_all.html.twig', [
            'categories' => $categories,
        ]);
    }

    #[Route('/category/add', name: 'app_category_add')]
    public function addCategory(Request $request){
        $category = new Category();
        $categoryForm = $this->createForm(CategoryType::class, $category);
        $categoryForm->handleRequest($request);

        if($categoryForm->isSubmitted() && $categoryForm->isValid()) {
            $message = "";
            $type = "";
            try {
                $this->categoryService->saveCategory($category);
                $message = "La catégorie a été ajouté";
                $type = "success";
            } catch (\Exception $e) {
                $message = $e->getMessage();
                $type = "danger";
            }
            $this->addFlash($type, $message);
        }

        return $this->render('category/category_add.html.twig', [
            'categoryForm' => $categoryForm,
        ]);
    }
}
