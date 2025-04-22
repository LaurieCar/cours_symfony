<?php

namespace App\Service;

use App\Repository\ArticleRepository;

class ArticleService
{
    public function __construct(
        private readonly ArticleRepository $articleRepository
    )
    {}

    public function getAllArticles() :array{
        try {
            //récupération des articles
            $articles = $this->articleRepository->findAll();
            // récupération des catégories pour chaque article
            foreach ($articles as $article) {
                $article->getCategories()->toArray();
                $user = $article->getUser();
            }
            // Tester si la liste est vide
            if(!$articles){
                // lever une exeption personnalisée
                throw new \Exception("La liste des articles est vide");
            }
        } catch (\Exception $e) {
            throw new \Exception();
        }
        // retourne la liste des articles
        return $articles;
    }
}