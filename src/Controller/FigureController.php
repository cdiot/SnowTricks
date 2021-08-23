<?php

namespace App\Controller;

use App\Entity\Figure;
use App\Form\FigureType;
use App\Repository\FigureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FigureController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/figure/new", name="new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $figure = new Figure();
        $figure->setPublishedAt(new \DateTime('now'));
        $form = $this->createForm(FigureType::class, $figure);
        $form->handleRequest($request);
        $figure = $form->getData();

        if ($form->isSubmitted() && $form->isValid()) {

            $search_figure = $this->entityManager->getRepository(Figure::class)->findOneByTitle($figure->getTitle());
            if (!$search_figure) {
                $this->entityManager->persist($figure);
                $this->entityManager->flush();

                $this->addFlash('notification', 'Une nouvelle figure viens d\'etre ajouter !');

                return $this->redirectToRoute('home');
            } else {
                $this->addFlash('notification', 'Cette figure existe déjà !');
            }
        }

        return $this->renderForm('figure/new.html.twig', [
            'figure' => $figure,
            'form' => $form
        ]);
    }

    /**
     * @Route("/figure/{id}/edit", name="edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Figure $figure): Response
    {
        $form = $this->createForm(FigureType::class, $figure);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('notification', 'La figure viens d\'etre modifier !');

            return $this->redirectToRoute('show');
        }

        return $this->renderForm('figure/edit.html.twig', [
            'figure' => $figure,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/figure//{id}/delete", name="delete", methods={"GET","POST"})
     */
    public function delete(Request $request, Figure $figure): Response
    {
        $this->entityManager->remove($figure);
        $this->entityManager->flush();

        $this->addFlash('notification', 'La figure viens d\'etre supprimer !');

        return $this->redirectToRoute('home');
    }
}
