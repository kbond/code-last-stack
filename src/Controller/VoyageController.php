<?php

namespace App\Controller;

use App\Entity\Voyage;
use App\Form\VoyageType;
use App\Repository\VoyageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/voyage')]
class VoyageController extends AbstractController
{
    #[Route('/', name: 'app_voyage_index', methods: ['GET'])]
    public function index(VoyageRepository $voyageRepository): Response
    {
        return $this->render('voyage/index.html.twig', [
            'voyages' => $voyageRepository->findBy([], ['id' => 'DESC'])
        ]);
    }

    #[Route('/new', name: 'app_voyage_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $voyage = new Voyage();
        $form = $this->createVoyageForm($voyage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($voyage);
            $entityManager->flush();

            $this->addFlash('success', 'Bon voyage!');

            if ($request->headers->has('turbo-frame')) {
                $stream = $this->renderBlockView('voyage/new.html.twig', 'stream_success', [
                    'voyage' => $voyage
                ]);

                $this->addFlash('stream', $stream);
            }

            return $this->redirectToRoute('app_voyage_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('voyage/new.html.twig', [
            'voyage' => $voyage,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_voyage_show', methods: ['GET'])]
    public function show(Voyage $voyage): Response
    {
        return $this->render('voyage/show.html.twig', [
            'voyage' => $voyage,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_voyage_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Voyage $voyage, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createVoyageForm($voyage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Voyage updated!');
            if ($request->headers->has('turbo-frame')) {
                $stream = $this->renderBlockView('voyage/edit.html.twig', 'stream_success', [
                    'voyage' => $voyage
                ]);

                $this->addFlash('stream', $stream);
            }

            return $this->redirectToRoute('app_voyage_edit', ['id' => $voyage->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('voyage/edit.html.twig', [
            'voyage' => $voyage,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_voyage_delete', methods: ['POST'])]
    public function delete(Request $request, Voyage $voyage, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$voyage->getId(), $request->request->get('_token'))) {
            $id = $voyage->getId();
            $entityManager->remove($voyage);
            $entityManager->flush();

            $this->addFlash('success', 'Voyage deleted!');

            if ($request->headers->has('turbo-frame')) {
                $stream = $this->renderBlockView('voyage/delete.html.twig', 'success_stream', [
                    'id' => $id,
                ]);

                $this->addFlash('stream', $stream);
            }
        }

        return $this->redirectToRoute('app_voyage_index', [], Response::HTTP_SEE_OTHER);
    }

    private function createVoyageForm(Voyage $voyage = null): FormInterface
    {
        $voyage = $voyage ?? new Voyage();

        return $this->createForm(VoyageType::class, $voyage, [
            'action' => $voyage->getId() ? $this->generateUrl('app_voyage_edit', ['id' => $voyage->getId()]) : $this->generateUrl('app_voyage_new'),
        ]);
    }
}
