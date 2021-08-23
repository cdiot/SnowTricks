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
    public function load(ObjectManager $manager)
    {
        // Create 2 category
        $categories = [
            1 => [
                'name' => 'Basic'
            ],
            2 => [
                'name' => 'Other'
            ],
        ];
        foreach ($categories as $key => $value) {
            $category = new Category();

            $category->setName($value['name']);

            $manager->persist($category);
        }

        // Create 6 products
        for ($j = 1; $j < 10; $j++) {
            $figure = new Figure();
            $today = new \DateTimeImmutable();
            $tomorrow = $today->modify('+1 day');
            $figure->setTitle('titre ' . $j)
                ->setSlug('slug ' . $j)
                ->setContent('content ' . $j)
                ->setPublishedAt($tomorrow)
                ->setCategory($category);

            $manager->persist($figure);
        }

        $manager->flush();
    }
}
