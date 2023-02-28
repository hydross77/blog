<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Repository\CategoryRepository;
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory as Faker;

class ArticleFixture extends Fixture
{
    protected CategoryRepository $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Faker::create('fr_FR');


        for ($i = 0; $i < 100; $i++) {


            $article = new Article();
            $article
                ->setTitle($faker->text(20))
                ->setContent($faker->text(180))
                ->setFeatureImage($faker->randomElement(['numerique.png']))
            ;
            $manager->persist($article);
        }

        $manager->flush();
    }

//    public function getDependencies(): array
//    {
//        return [
//            UserFixtures::class,
//            CategoryFixture::class,
//        ];
//    }
}
