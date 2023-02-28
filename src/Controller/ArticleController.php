<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{

     #[Route('/article/{id}', name: 'show_article')]
    public function show(Article $article, ManagerRegistry $doctrine): Response
     {
        return $this->render('article/show.html.twig', [
            'article' => $article,
        ]);;
    }
}
