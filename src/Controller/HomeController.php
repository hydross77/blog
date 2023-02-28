<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\ArticleRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    #[Route('/', name: 'app_home')]
    public function index(ManagerRegistry $doctrine, ArticleRepository $articleRepo): Response
    {

        $category = $doctrine->getRepository(Category::class)->findAll();

        // affiche les 10 derniers articles
        $articlesTen = $articleRepo->articlesTen();


        return $this->render('home/index.html.twig', [
            'category' => $category,
            'articlesTen' => $articlesTen
        ]);
    }


    #[Route('/category/{id}', name: "show_category")]
    public function show(Category $category)
    {
        return $this->render('home/show.html.twig', [
            'category' => $category,
        ]);
    }
}
