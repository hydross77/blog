<?php

namespace App\Controller;

use App\Entity\Category;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    #[Route('/', name: 'app_home')]
    public function index(ManagerRegistry $doctrine): Response
    {

        $category = $doctrine->getRepository(Category::class)->findAll();

        return $this->render('home/index.html.twig', [
            'category' => $category,
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
