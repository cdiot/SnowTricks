<?php

namespace App\Controller;

use App\Entity\Figure;
use App\Form\FigureType;
use App\Repository\FigureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
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
     *  @IsGranted("ROLE_USER")
     */
    public function new(Request $request): Response
    {
        $form = $this->createForm(FigureType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($form->getData());
            $this->entityManager->flush();
            $this->addFlash('notification', 'Une nouvelle figure viens d\'etre ajouter !');

            return $this->redirectToRoute('home');
        }

        return $this->renderForm('figure/new.html.twig', [
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
            $this->entityManager->flush();

            $this->addFlash('notification', 'La figure viens d\'etre modifier !');

            return $this->redirectToRoute('show');
        }

        return $this->renderForm('figure/edit.html.twig', [
            'figure' => $figure,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/figure/{id}/delete", name="delete", methods={"GET","POST"})
     */
    public function delete(Request $request, Figure $figure): Response
    {
        $this->entityManager->remove($figure);
        $this->entityManager->flush();

        $this->addFlash('notification', 'La figure viens d\'etre supprimer !');

        return $this->redirectToRoute('home');
    }
}
