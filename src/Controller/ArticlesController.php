<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comment;
use Doctrine\DBAL\Types\TextType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Id;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Form\ArticlesFormType;
use App\Form\CommentType;
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

    #[Route('/articles/id={id}', name: 'app_article_detail')]
    public function detailArticle(ManagerRegistry $doctrine, int $id, Request $request, EntityManagerInterface $entityManager): Response
    {
        $repositoryArticle = $doctrine->getRepository(Article::class);
        $articles = $repositoryArticle->findOneBy(['id' => $id]);


        $repositoryComment = $doctrine->getRepository(Comment::class);
        $comments = $repositoryComment->findBy(['article' => $id], ['createdAt' => 'DESC']);
//        dd($comments);
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() && $this->getUser()) {
            $comment->setUser($this->getUser());
            $comment->setCreatedAt(new \DateTime('now'));
            $comment->setArticle($articles);

            $entityManager->persist($comment);
            $entityManager->flush();

            return $this->redirectToRoute('app_article_detail', ['id' => $id]);
        }


        return $this->render('articles/detail.html.twig', [
                'article' => $articles,
                'comments' => $comments,
                'commentsForm' => $form->createView(),
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
