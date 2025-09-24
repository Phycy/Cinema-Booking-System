<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(): Response
    {
        return $this->render('home.html.twig', [
            'title' => 'Cinema Booking System',
        ]);
    }


    #[Route('/movies', name: 'movies')]
    public function movies(): Response
    {   
    return $this->render('movies.html.twig', [
        'title' => 'Movies List',
    ]);
    }


    #[Route('/booking', name: 'booking')]
    public function booking(): Response
    {   
    return $this->render('booking.html.twig', [
        'title' => 'Booking List',
    ]);
    }

    #[Route('/login', name: 'login')]
    public function login(): Response
    {   
    return $this->render('login.html.twig', [
        'title' => 'Login',
    ]);
    }


}




?>