<?php

namespace App\Controller;

use App\Entity\Figure;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {

        $figures = $this->entityManager->getRepository(Figure::class)->findAll();

        return $this->render('home/index.html.twig', [
            'figures' => $figures
        ]);
    }

    /**
     * @Route("/{id}", name="figure_show", methods={"GET"})
     */
    public function show(Figure $figure): Response
    {
        return $this->render('figure/show.html.twig', [
            'figure' => $figure,
        ]);
    }
}
