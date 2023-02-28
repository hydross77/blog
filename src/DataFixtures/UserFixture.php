<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory as Faker;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * génère de fausses données pour l'entité User
 */
class UserFixture extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordHasherInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager): void
    {
        $admin = new User();
        $admin
            ->setEmail('admin@blog.fr')
            ->setUsername('Tiffany')
            ->setRoles(['ROLE_ADMIN'])
            ->setPassword($this->encoder->hashPassword($admin, 'admin'))
        ;
        $manager->persist($admin);

        $author = new User();
        $author
            ->setEmail('author@blog.fr')
            ->setUsername('Adrien')
            ->setRoles(['ROLE_AUTHOR'])
            ->setPassword($this->encoder->hashPassword($author, 'author'))
        ;
        $manager->persist($author);

        $password = $this->encoder->hashPassword(new user(), 'password');
        $faker = Faker::create('fr_FR');
        for ($i=0; $i < 50; $i++) {
            $user = new User();
            $user
                ->setEmail($faker->email())
                ->setPassword($password)
                ->setUsername($faker->firstName)
            ;
            $manager->persist($user);
        }

        $manager->flush();
    }
}