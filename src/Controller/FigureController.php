<?php

namespace App\Controller;

use App\Entity\Figure;
use App\Entity\Illustration;
use App\Form\FigureType;
use App\Manager\FigureManager;
use App\Repository\FigureRepository;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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
    public function new(Request $request, FigureManager $figureManager, FileUploader $fileUploader): Response
    {
        $form = $this->createForm(FigureType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $images = $form->get('files')->getData();

            $figureManager->create($form->getData(), $images, $fileUploader);
            $this->addFlash('notification', 'Une nouvelle figure viens d\'etre ajouter !');

            return $this->redirectToRoute('home');
        }

        return $this->renderForm('figure/new.html.twig', [
            'form' => $form
        ]);
    }

    /**
     * @Route("/figure/{slug}/edit", name="edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Figure $figure, FigureManager $figureManager, FileUploader $fileUploader): Response
    {
        $form = $this->createForm(FigureType::class, $figure);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $images = $form->get('files')->getData();
            $figureManager->create($form->getData(), $images, $fileUploader);
            $this->addFlash('notification', 'La figure viens d\'etre modifier !');

            return $this->redirectToRoute('show', ['slug' => $figure->getSlug()]);
        }

        return $this->renderForm('figure/edit.html.twig', [
            'figure' => $figure,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/figure/{slug}/delete", name="delete", methods={"GET","POST"})
     */
    public function delete(Request $request, Figure $figure): Response
    {
        $this->entityManager->remove($figure);
        $this->entityManager->flush();

        $this->addFlash('notification', 'La figure viens d\'etre supprimer !');

        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/delete/illustration/{id}", name="delete_illustration", methods={"DELETE"})
     */
    public function deleteImage(Illustration $illustration, Request $request)
    {
        $data = json_decode($request->getContent(), true);

        if ($this->isCsrfTokenValid('delete' . $illustration->getId(), $data['_token'])) {
            $name = $illustration->getName();
            unlink($this->getParameter('images_directory') . '/' . $name);
            $this->entityManager->remove($illustration);
            $this->entityManager->flush();

            return new JsonResponse(['success' => 1]);
        } else {
            return new JsonResponse(['error' => 'Token Invalide'], 400);
        }
    }
}
