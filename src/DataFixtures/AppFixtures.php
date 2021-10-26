<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Comment;
use App\Entity\Figure;
use App\Entity\Illustration;
use App\Entity\User;
use App\Entity\Video;
use App\Service\FileUploader;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Validator\Constraints\Date;

class AppFixtures extends Fixture
{
    private $categoriesData = ['Basique', 'Freestyle', 'Autres'];

    private $passwordHasher;

    private $filesystem;

    private $fileUploader;

    public function __construct(UserPasswordHasherInterface $passwordHasher, Filesystem $filesystem, FileUploader $fileUploader)
    {
        $this->passwordHasher = $passwordHasher;
        $this->filesystem = $filesystem;
        $this->fileUploader =  $fileUploader;
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

        // Create 1 spécific user
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


        // Create 11 figures
        $figures = [];
        for ($j = 1; $j < 11; $j++) {
            $figure = new Figure();
            $today = new DateTime();
            $tomorrow = $today->modify('+1 day');
            $figure->setTitle('figure ' . $j)
                ->setSlug('figure-' . $j)
                ->setContent('La description en détails de ma figure numero ' . $j)
                ->setCreatedAt($today)
                ->setPublishedAt($tomorrow)
                ->setCategory($categories[array_rand($categories)]);

            // 2 Images
            for ($k = 1; $k < 2; $k++) {
                $this->filesystem->copy(__DIR__ . '/img/' . $k . '.jpg', __DIR__ . 'tmp.jpg');
                $file = new UploadedFile(__DIR__ . 'tmp.jpg', "Figure_{$j}_{$k}.jpg", null, null, true);


                $illustration = new Illustration();
                $illustration->setName($this->fileUploader->upload($file))
                    ->setImages($figure);

                $manager->persist($illustration);
            }

            // 1 to 3 Video
            for ($l = 0; $l < mt_rand(1, 3); $l++) {
                $video = new Video();
                $video->setUrl('https://www.youtube.com/embed/V9xuy-rVj9w')
                    ->setFigure($figure);

                $manager->persist($video);
            }

            // Create * comment
            for ($k = 0; $k < mt_rand(4, 15); $k++) {
                $mots = ['Salut super figure !!', 'Bonjour j\'adore !', 'Pas mal...', 'Pas ouf du tout.', 'Bravo!!', 'Génial!', 'Continue.'];
                $num = rand(0, 3);
                $comment = new Comment();
                $today = new DateTime();
                $tomorrow = $today->modify('+1 day');
                $comment->setMessage($mots[$num]);
                $comment->setCreatedAt($tomorrow);
                $comment->setFigure($figure);
                $comment->setUser($user);

                $manager->persist($comment);
            }


            $manager->persist($figure);
            $figures[] = $figure;
        }

        $manager->flush();
    }
}
