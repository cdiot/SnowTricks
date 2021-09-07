<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Figure;
use App\Form\CommentType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
     * @Route("show/{slug}", name="show", methods={"GET","POST"})
     */
    public function show(Figure $figure, Request $request): Response
    {
        $form = $this->createForm(CommentType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment = $form->getData();
            $comment->setUser($this->getUser());
            $comment->setFigure($figure);
            $this->entityManager->persist($comment);
            $this->entityManager->flush();
            $this->addFlash('notification', 'Votre message a était ajouté.');
        }
        return $this->render('home/show.html.twig', [
            'figure' => $figure,
            'form' => $form->createView()
        ]);
    }
}
