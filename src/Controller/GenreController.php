<?php

namespace App\Controller;

use App\Repository\GenreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class GenreController extends AbstractController
{

    #[Route('/genre/{slug}', name: 'app_genre')]
    public function index($slug, GenreRepository $genreRepository): Response
    {
        $genre = $genreRepository->findOneBySlug($slug);

        if (!$genre) {
            return $this->redirectToRoute('app_home');
        }

        return $this->render('genre/index.html.twig', [
            'genre' => $genre,
        ]);
    }
}
