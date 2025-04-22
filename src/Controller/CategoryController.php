<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Service\CategoryService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
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
        
        return $this->render('category/index.html.twig', [
            'categories' => $categories,
        ]);
    }
}
