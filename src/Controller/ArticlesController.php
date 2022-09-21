<?php

namespace App\Controller;

use App\Entity\Article;
use Doctrine\DBAL\Types\TextType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Id;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Form\ArticlesFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

class ArticlesController extends AbstractController
{
    #[Route('/articles', name: 'app_articles')]
    public function showArticles(ManagerRegistry $doctrine, PaginatorInterface $paginator, Request $request): Response
    {

        $repository = $doctrine->getRepository(Article::class);
        $articles = $repository->findAll();

        $allArticles = $paginator->paginate(
            $articles,
            $request->query->getInt('page', 1),
            10);


        return $this->render('articles/index.html.twig', [
            'allArticles' => $allArticles,
        ]);
    }

    #[Route('/articles/{id}', name: 'app_article_detail')]
    public function detailArticle(ManagerRegistry $doctrine, int $id): Response
    {
        $repository = $doctrine->getRepository(Article::class);
        $articles = $repository->findOneBy(['id' => $id]);

//        dd($articles);

        return $this->render('articles/detail.html.twig', [
                'article' => $articles,
        ]);

    }

    #[Route('/articles/create', name: 'app_article_create')]
    public function createArticle(Request $request, EntityManagerInterface $entityManager): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticlesFormType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() && $this->getUser()) {
            $article->setUser($this->getUser());
            $article->setCreatedAt(new \DateTime('now'));

            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('app_articles');

        }

        return $this->render('articles/create.html.twig', [
            'articleForm' => $form->createView(),
        ]);

    }
}
