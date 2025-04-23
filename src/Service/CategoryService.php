<?php

namespace App\Service;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;

class CategoryService
{
    public function __construct(
        private readonly CategoryRepository $categoryRepository,
        private readonly EntityManagerInterface $entityManager,
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

    public function saveCategory(Category $category) {
        try {
            // Test si la catégorie n'existe pas déjà
            if($this->categoryRepository->findOneBy(["label"=>$category->getLabel()])) {
                throw new \Exception("La catégorie existe déjà");
            }
            // Ajouter en BDD
            $this->entityManager->persist($category);
            $this->entityManager->flush();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
        
        return true;
    }
}
