<?php

namespace App\Manager;

use App\Entity\Figure;
use App\Entity\Illustration;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\String\Slugger\AsciiSlugger;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FigureManager extends AbstractController
{

    public function __construct(EntityManagerInterface $em, FileUploader $fileUploader)
    {
        $this->em = $em;
        $this->uploader = $fileUploader;
    }


    public function create(Figure $figure, array $images)
    {
        //generate slug
        $slugger = new AsciiSlugger();
        $figure->setSlug($slugger->slug($figure->getTitle()));

        //manage uploads
        foreach ($images as $image) {
            $file = $this->uploader->upload($image);

            $img = new Illustration;
            $img->setName($file);
            $figure->addIllustration($img);
        }
        $this->em->persist($figure);
        $this->em->flush();
    }
}
