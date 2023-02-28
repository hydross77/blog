<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

     #[Route('/article/{slug}', name: 'show_article')]
    public function show(Article $article, Request $request): Response
     {

//         $user = $this->getUser();

         $creatComment = new Comment;
         $form = $this->createForm(CommentType::class, $creatComment);
         $form->handleRequest($request);

         if ($form->isSubmitted() && $form->isValid()) {
             $creatComment->setUser($this->getUser());

             $this->entityManager->persist($creatComment);
             $this->entityManager->flush();

             $this->addFlash("message", "Commentaire publié.");
             return $this->redirectToRoute("app_home");
         }


        return $this->render('article/show.html.twig', [
            'article' => $article,
            'comment'=>$creatComment,
            'form' => $form->createView()
        ]);
    }


}
