<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'home')]
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
    public function login(Request $request): Response
    {
        $session = $request->getSession();
        $error = null;

        if ($request->isMethod('POST')) {
            $username = $request->request->get('username');
            $password = $request->request->get('password');

            $user = $session->get('user');

            if ($user && $user['username'] === $username && $user['password'] === $password) {
                $session->set('is_logged_in', true);
                return $this->redirectToRoute('dashboard');
            } else {
                $error = "Invalid username or password!";
            }
        }

        return $this->render('login.html.twig', [
            'title' => 'Login',
            'error' => $error
        ]);
    }

    #[Route('/register', name: 'register')]
    public function register(Request $request): Response
    {
        $session = $request->getSession();
        $message = null;

        if ($request->isMethod('POST')) {
            $username = $request->request->get('username');
            $password = $request->request->get('password');
            $email = $request->request->get('email');

            $session->set('user', [
                'username' => $username,
                'password' => $password,
                'email' => $email,
            ]);

            $message = "Account created successfully! You can now log in.";
        }

        return $this->render('register.html.twig', [
            'title' => 'Register',
            'message' => $message
        ]);
    }

    #[Route('/dashboard', name: 'dashboard')]
    public function dashboard(Request $request): Response
    {
        $session = $request->getSession();

        if (!$session->get('is_logged_in')) {
            return $this->redirectToRoute('login');
        }

        $user = $session->get('user');

        return $this->render('dashboard.html.twig', [
            'title' => 'User Dashboard',
            'user' => $user
        ]);
    }

    #[Route('/logout', name: 'logout')]
    public function logout(Request $request): Response
    {
        $session = $request->getSession();
        $session->clear();

        return $this->redirectToRoute('home');
    }
}


?>