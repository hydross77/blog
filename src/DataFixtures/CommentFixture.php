<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Comment;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory as Faker;

class CommentFixture extends Fixture implements DependentFixtureInterface
{

    public function __construct(
        private UserRepository $userRepository,
        private ArticleRepository $articleRepository,
    ) {}


    public function load(ObjectManager $manager): void
    {
        $faker = Faker::create('fr_FR');

        $articles = $this->articleRepository->findAll();

        for ($i = 0; $i < 300; $i++) {
            $comment = new Comment();
            $randomArticle = array_rand($articles);
            $article = $articles[$randomArticle];

            $comment
                ->setContent($faker->sentences(3, true))
                ->setIsActive($faker->randomElement([1, 0]))
                ->setUser($this->getReference(UserFixture::AUTHOR_USER_REFERENCE))
                ->setArticle($article)
            ;
            $manager->persist($comment);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return array(
            UserFixture::class,
        );
    }
}
