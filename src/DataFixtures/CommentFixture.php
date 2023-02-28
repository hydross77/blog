<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Comment;
use App\Repository\CategoryRepository;
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory as Faker;

class CommentFixture extends Fixture
{

//    protected UserRepository $userRepository;
//    protected ArticleRepository $articleRepository;

    public function load(ObjectManager $manager): void
    {

        $faker = Faker::create('fr_FR');

        $comment = new Comment();

//        $user = $this->userRepository->findAll();
//        $userLength = count($user)-1;
//        $article = $this->articleRepository->findAll();
//        $articleLength = count($article)-1;

        for ($i=0; $i < 300; $i++) {
//            $userRandomKey = rand(0, $userLength);
//            $articleRandomKey = rand(0, $articleLength);

//            $user = $user[$userRandomKey];
//            $article = $article[$articleRandomKey];


            $comment = new Comment();
            $comment
                ->setContent($faker->text(10))
                ->setIsActive($faker->randomElement([1, 0]))
            ;
            $manager->persist($comment);
        }

        $manager->flush();
    }
}
