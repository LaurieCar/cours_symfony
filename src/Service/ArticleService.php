<?php

namespace App\Service;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;

class ArticleService
{
    public function __construct(
        private readonly ArticleRepository $articleRepository,
        private readonly EntityManagerInterface $entityManager
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

    public function saveArticle(Article $article) {
        try {
            // Test si l'article existe déjà
            if($this->articleRepository->findOneBy([
                "title"=>$article->getTitle(),
                "content"=>$article->getContent()
                ])) {
                    throw new \Exception("L'article existe déjà");
                }
            // Ajouter l'article en BDD
            $this->entityManager->persist($article);
            $this->entityManager->flush();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
        return true;  
    }
}
