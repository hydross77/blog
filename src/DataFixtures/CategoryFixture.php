<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory as Faker;

class CategoryFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $category = new Category();

        $faker = Faker::create('fr_FR');
        for ($i=0; $i < 10; $i++) {
            $category = new Category();
            $category
                ->setName($faker->text(10))
            ;
            $manager->persist($category);
        }

        $manager->flush();
    }
}
