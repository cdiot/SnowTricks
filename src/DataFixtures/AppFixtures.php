<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Comment;
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



        // Create 6 figures
        $figures = [];
        for ($j = 1; $j < 11; $j++) {
            $figure = new Figure();
            $today = new DateTime();
            $tomorrow = $today->modify('+1 day');
            $figure->setTitle('figure ' . $j)
                ->setSlug('figure-' . $j)
                ->setContent('La description en détails de ma figure numero ' . $j)
                ->setPublishedAt($tomorrow)
                ->setCategory($categories[array_rand($categories)]);

            $manager->persist($figure);
            $figures[] = $figure;
        }

        // Create 1 user
        $user = new User();
        $user->setFirstname('thomas');
        $user->setLastname('sewogi');
        $user->setEmail('thomas@gmail.com');
        $user->setIsVerified(true);

        $user->setPassword($this->passwordHasher->hashPassword(
            $user,
            '123456'
        ));
        $manager->persist($user);

        // Create 1 comment

        for ($k = 0; $k < 15; $k++) {
            $mots = ['salut', 'bonjour', 'aurevoir', 'joker'];
            $num = rand(0, 3);
            $comment = new Comment();
            $today = new DateTime();
            $tomorrow = $today->modify('+1 day');
            $comment->setMessage($mots[$num]);
            $comment->setCreatedAt($tomorrow);
            $comment->setFigure($figures[array_rand($figures)]);
            $comment->setUser($user);

            $manager->persist($comment);
        }

        $manager->flush();
    }
}
