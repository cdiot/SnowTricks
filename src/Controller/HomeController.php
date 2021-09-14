<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Figure;
use App\Form\CommentType;
use App\Manager\CommentManager;
use App\Repository\CommentRepository;
use App\Repository\FigureRepository;
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
    public function index(FigureRepository $figureRepository): Response
    {
        return $this->render('home/index.html.twig', [
            'figures' => $figureRepository->findAll()
        ]);
    }

    /**
     * @Route("show/{slug}", name="show", methods={"GET","POST"})
     */
    public function show(Figure $figure, Request $request, CommentManager $commentManager, CommentRepository $commentRepository): Response
    {
        $form = $this->createForm(CommentType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $commentManager->addCommentTo($figure, $this->getUser(), $form->getData());
            $this->addFlash('notification', 'Votre message a était ajouté.');
            $this->redirectToRoute('show', ['slug' => $figure->getSlug()]);
        }
        $offset = max(0, $request->query->getInt('offset', 0));
        $paginator = $commentRepository->getCommentPaginator($figure, $offset);

        return $this->render('home/show.html.twig', [
            'figure' => $figure,
            'comments' => $paginator,
            'previous' => $offset - CommentRepository::PAGINATOR_PER_PAGE,
            'next' => min(count($paginator), $offset + CommentRepository::PAGINATOR_PER_PAGE),
            'form' => $form->createView()
        ]);
    }
}
