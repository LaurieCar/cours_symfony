<?php

namespace App\Service;

use App\Repository\CategoryRepository;

class CategoryService
{
    public function __construct(
        private readonly CategoryRepository $categoryRepository
    )
    {}

    public function getAllCategories() :array{
        try {
            //récupération des catégories
            $categories = $this->categoryRepository->findAll();
            // Tester si la liste est vide
            if(!$categories){
                // lever une exeption personnalisée
                throw new \Exception("La liste des catégories est vide");
            }
        } catch (\Exception $e) {
            throw new \Exception();
        }
        // retourne la liste des catégories
        return $categories;
    }
}