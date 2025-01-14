<?php

namespace App\Controller\Api;

use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;

class ArticleController extends AbstractController
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    #[Route('/api/article', name: 'api_articles')]
    public function index(): Response
    {
        return $this->json($this->entityManager->getRepository(Article::class)->findAll());
    }

    #[Route('/api/article/create', name: 'api_article_create', methods: 'POST')]
    public function create(Request $request): Response
    {
        $data = json_decode($request->getContent(), true, flags: JSON_THROW_ON_ERROR);

        $article = new Article();
        $article->setTitle($data['title']);
        $article->setContent($data['content']);

        $this->entityManager->persist($article);
        $this->entityManager->flush();

        return new Response('', Response::HTTP_OK);
    }

    #[Route('/api/article/update', name: 'api_article_update', methods: 'POST')]
    public function update(Request $request): Response
    {
        $articlesData = json_decode($request->getContent(), true, flags: JSON_THROW_ON_ERROR);
        $article = $this->entityManager->getRepository(Article::class)->find($articlesData['id']);

        if (null === $article) {
            throw new NotFoundHttpException();
        }

        $article->setTitle($articlesData['title']);
        $article->setContent($articlesData['content']);

        $this->entityManager->flush();

        return new Response('', Response::HTTP_OK);
    }

    #[Route('/api/article/destroy', name: 'api_article_destroy', methods: 'DELETE')]
    public function destroy(Request $request): Response
    {
        $articlesData = json_decode($request->getContent(), true, flags: JSON_THROW_ON_ERROR);
        $article = $this->entityManager->getRepository(Article::class)->find($articlesData['id']);

        if (null === $article) {
            throw new NotFoundHttpException();
        }

        $this->entityManager->remove($article);
        $this->entityManager->flush();

        return new Response('', Response::HTTP_OK);
    }
}
