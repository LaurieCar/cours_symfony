<?php

namespace App\Controller;

use App\Service\ArticleService;
use App\Entity\Article;
use App\Form\ArticleType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

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
        return $this->render('article/articles_all.html.twig', [
            'articles' => $articles,
        ]);

    }

    #[Route('/article/add', name: 'app_article_add')]
    #[IsGranted("ROLE_USER")]
    public function addArticle(Request $request) 
    {
        // Objet article (recevoir le résultat du formulaire)
        $article = new Article;
        // Créer un formulaire
        $articleForm = $this->createForm(ArticleType::class, $article);
        $articleForm->handleRequest($request);

        // test si le formulaire est soumis
        if($articleForm->isSubmitted()) {
            try {
                $message = "";
                $type = "";
                if($this->articleService->saveArticle($article)) {
                    $message = "L'article " . $article->getTitle() . " a été ajouté ";
                    $type = "success";
                }
            } catch (\Exception $e) {
                $message = $e->getMessage();
                $type = "danger";
            }
            $this->addFlash($type, $message);
        }

        return $this->render('article/article_add.html.twig', [
            'articleForm' => $articleForm,
        ]);
    }
}
