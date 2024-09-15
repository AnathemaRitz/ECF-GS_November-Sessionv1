<?php

namespace App\Twig;

use App\Class\Cart;
use App\Repository\GameRepository;
use App\Repository\GenreRepository;
use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;
use Twig\TwigFilter;

class AppExtensions extends AbstractExtension implements GlobalsInterface
{
    private $genreRepository;
    private $cart;
    private $gameRepository;

    public function __construct(GenreRepository $genreRepository, Cart $cart, GameRepository $gameRepository)
    {
        $this->genreRepository = $genreRepository;
        $this->cart = $cart;
        $this->gameRepository = $gameRepository;
    }
    public function getFilters()
    {
        return [
            new TwigFilter('price', [$this, 'formatPrice'])
        ];
    }

    public function formatPrice($number)
    {
        return number_format($number, '2', ','). ' €';
    }

    public function getGlobals(): array
    {
        return [
            'allGenres' => $this->genreRepository->findAll(),
            'allGames' => $this->gameRepository->findAll(),
            'fullCartQuantity' => $this->cart->fullQuantity()
        ];
    }

}


