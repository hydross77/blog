<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Repository\CategoryRepository;
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory as Faker;
use Symfony\Component\String\Slugger\SluggerInterface;

class ArticleFixture extends Fixture implements DependentFixtureInterface
{

    public function __construct(
        private UserRepository $userRepository,
        private CategoryRepository $categoryRepository,
        private SluggerInterface $sluggerInterface
    ) {}


    public function load(ObjectManager $manager): void
    {
        $faker = Faker::create('fr_FR');

        $categories = $this->categoryRepository->findAll();

        for ($i = 0; $i < 100; $i++) {
            $article = new Article();
            $randomCategory = array_rand($categories);
            $category = $categories[$randomCategory];

            $article
                ->setTitle($faker->words(3, true))
                ->setContent($faker->sentences(3, true))
                ->setFeatureImage($faker->randomElement(['numerique.png']))
                ->setStatus(1)
               // ->setUser($this->getReference(UserFixture::AUTHOR))
                ->setFeaturedText($faker->sentence())
                ->setBelong($category)
                ->setSlug($this->sluggerInterface->slug($article->getTitle()))
            ;
            $manager->persist($article);
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
