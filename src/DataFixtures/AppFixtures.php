<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Figure;
use App\Entity\User;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Validator\Constraints\Date;

class AppFixtures extends Fixture
{
    private $categoriesData = ['Basic', 'Other', 'Freestyle'];

    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }


    public function load(ObjectManager $manager)
    {

        $categories = [];
        foreach ($this->categoriesData as $categoryName) {
            $category = new Category();
            $category->setName($categoryName);
            $manager->persist($category);
            $categories[] = $category;
        }



        // Create 6 products
        for ($j = 0; $j < 10; $j++) {
            $figure = new Figure();
            $today = new DateTime();
            $tomorrow = $today->modify('+1 day');
            $figure->setTitle('titre ' . $j)
                ->setSlug('slug ' . $j)
                ->setContent('content ' . $j)
                ->setPublishedAt($tomorrow)
                ->setCategory($categories[array_rand($categories)]);

            $manager->persist($figure);
        }

        // Create 1 user
        $user = new User();
        $user->setEmail('thomas@gmail.com');
        $user->setIsVerified(true);

        $user->setPassword($this->passwordHasher->hashPassword(
            $user,
            '123456'
        ));
        $manager->persist($user);

        $manager->flush();
    }
}
