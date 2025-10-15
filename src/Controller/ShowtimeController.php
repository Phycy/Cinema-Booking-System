<?php

namespace App\Controller;

use App\Entity\Showtime;
use App\Form\ShowtimeType;
use App\Repository\ShowtimeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/showtime')]
final class ShowtimeController extends AbstractController
{
    #[Route(name: 'app_showtime_index', methods: ['GET'])]
    public function index(ShowtimeRepository $showtimeRepository): Response
    {
        return $this->render('showtime/index.html.twig', [
            'showtimes' => $showtimeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_showtime_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $showtime = new Showtime();
        $form = $this->createForm(ShowtimeType::class, $showtime);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($showtime);
            $entityManager->flush();

            return $this->redirectToRoute('app_showtime_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('showtime/new.html.twig', [
            'showtime' => $showtime,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_showtime_show', methods: ['GET'])]
    public function show(Showtime $showtime): Response
    {
        return $this->render('showtime/show.html.twig', [
            'showtime' => $showtime,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_showtime_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Showtime $showtime, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ShowtimeType::class, $showtime);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_showtime_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('showtime/edit.html.twig', [
            'showtime' => $showtime,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_showtime_delete', methods: ['POST'])]
    public function delete(Request $request, Showtime $showtime, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$showtime->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($showtime);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_showtime_index', [], Response::HTTP_SEE_OTHER);
    }
}
