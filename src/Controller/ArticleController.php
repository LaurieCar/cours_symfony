<?php

namespace App\Controller;

use App\Service\ArticleService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ArticleController extends AbstractController
{
    public function __construct(
        private readonly ArticleService $articleService
    )
    {}

    #[Route('/articles', name: 'app_article_all')]
    public function showAll(): Response
    {
        try {
            $articles = $this->articleService->getAllArticles();
        } catch (\Exception $e) {
            $articles = null;
        }
        return $this->render('article/index.html.twig', [
            'articles' => $articles,
        ]);
    }
}
