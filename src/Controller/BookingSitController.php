<?php

namespace App\Controller;

use App\Entity\BookingSit;
use App\Form\BookingSitType;
use App\Repository\BookingSitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/booking/sit')]
final class BookingSitController extends AbstractController
{
    #[Route(name: 'app_booking_sit_index', methods: ['GET'])]
    public function index(BookingSitRepository $bookingSitRepository): Response
    {
        return $this->render('booking_sit/index.html.twig', [
            'booking_sits' => $bookingSitRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_booking_sit_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $bookingSit = new BookingSit();
        $form = $this->createForm(BookingSitType::class, $bookingSit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($bookingSit);
            $entityManager->flush();

            return $this->redirectToRoute('app_booking_sit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('booking_sit/new.html.twig', [
            'booking_sit' => $bookingSit,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_booking_sit_show', methods: ['GET'])]
    public function show(BookingSit $bookingSit): Response
    {
        return $this->render('booking_sit/show.html.twig', [
            'booking_sit' => $bookingSit,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_booking_sit_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, BookingSit $bookingSit, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BookingSitType::class, $bookingSit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_booking_sit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('booking_sit/edit.html.twig', [
            'booking_sit' => $bookingSit,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_booking_sit_delete', methods: ['POST'])]
    public function delete(Request $request, BookingSit $bookingSit, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$bookingSit->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($bookingSit);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_booking_sit_index', [], Response::HTTP_SEE_OTHER);
    }
}
