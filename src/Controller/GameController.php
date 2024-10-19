<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\GameRepository;

class GameController extends AbstractController

{
    #[Route('/game/{slug}', name: 'app_game')]
    public function index($slug, GameRepository $gameRepository): Response
    {
        $game = $gameRepository->findOneBySlug($slug);

        if (!$game) {
            return $this->redirectToRoute('app_home');
        }

        return $this->render('game/index.html.twig', [
            'game' => $game,
        ]);
    }
}
