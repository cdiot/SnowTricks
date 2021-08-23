<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Figure;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Validator\Constraints\Date;

class AppFixtures extends Fixture
{
    public $categoriesData = ['Basic', 'Other', 'Freestyle'];


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
        for ($j = 1; $j < 10; $j++) {
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

        $manager->flush();
    }
}
