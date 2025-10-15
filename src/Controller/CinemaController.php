<?php

namespace App\Controller;

use App\Entity\Movies;
use App\Form\MoviesType;
use App\Repository\MoviesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/cinema')]
final class CinemaController extends AbstractController
{
    #[Route(name: 'app_cinema_index', methods: ['GET'])]
    public function index(MoviesRepository $moviesRepository): Response
    {
        return $this->render('cinema/index.html.twig', [
            'movies' => $moviesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_cinema_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $movie = new Movies();
        $form = $this->createForm(MoviesType::class, $movie, [
        'attr' => ['novalidate' => 'novalidate'],
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($movie);
            $entityManager->flush();

            return $this->redirectToRoute('app_cinema_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('cinema/new.html.twig', [
            'movie' => $movie,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_cinema_show', methods: ['GET'])]
    public function show(Movies $movie): Response
    {
        return $this->render('cinema/show.html.twig', [
            'movie' => $movie,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_cinema_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Movies $movie, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MoviesType::class, $movie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_cinema_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('cinema/edit.html.twig', [
            'movie' => $movie,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_cinema_delete', methods: ['POST'])]
    public function delete(Request $request, Movies $movie, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$movie->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($movie);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_cinema_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/back-home', name: 'back_home')] 
    public function backHome(): Response { 
        return $this->redirectToRoute('home'); 
    }


}
