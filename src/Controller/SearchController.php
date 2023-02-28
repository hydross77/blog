<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\SearchForm;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/search/article', name: 'app_bdr')]
    public function index(ArticleRepository $repository, Request $request): Response
    {

        $articles = $this->entityManager->getRepository(Article::class);

        $searchArticle = $this->createForm(SearchForm::class, null);
        $searchArticle->handleRequest($request);

        if ($searchArticle->isSubmitted() && $searchArticle->isValid()) {
            $request->query->remove('_token');

            return $this->redirectToRoute('app_result', $request->query->all());
        };

        return $this->render('search/index.html.twig', [
            'searchArticle' => $searchArticle->createView(),
            'articles' => $articles,
        ]);
    }

    #[Route('/search/result', name: 'app_result')]
    public function result(Request $request, ArticleRepository $repository, PaginatorInterface $paginator): Response
    {
        $query = $request->query->get('article');
        $user = $this->getUser() ?? null;

//        $articles = $repository->findSearch([
//            'article' => $query,
//        ]);

        $articles = $paginator->paginate(
            $repository->findSearch([
                'article' => $query,
            ]),
            $request->query->getInt('page', 1),
            5
        );

        return $this->render('search/result.html.twig', [
            'articles' => $articles ?? null,
            'user' => $user ?? null,
        ]);
    }
}
