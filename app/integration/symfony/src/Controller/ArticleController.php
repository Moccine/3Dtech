<?php

namespace App\Controller;

use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    public const DEFAULT_QUANTITY_ARTICLE = 6;

    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/article/{slug}", name="article", methods={"GET", "POST"})
     */
    public function index(Article $article): Response
    {
        $articles = $this->entityManager->getRepository(Article::class)->getArticles();

        return $this->render('article/index.html.twig', [
            'slug' => $article->getSlug(),
            'articles' => $articles,
        ]);
    }
}
