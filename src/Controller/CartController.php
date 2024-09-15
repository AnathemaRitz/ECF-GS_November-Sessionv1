<?php

namespace App\Controller;

use App\Class\Cart;
use App\Repository\GameRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CartController extends AbstractController
{
    #[Route('/cart', name: 'app_cart')]
    public function index(Cart $cart): Response
    {
        return $this->render('cart/index.html.twig',[
            'cart'=> $cart->getCart(),
            'total' => $cart->getTotal(),
        ]);
    }

    #[Route('/cart/add/{id}', name: 'app_cart_add')]
    public function add($id,Cart $cart, GameRepository $gameRepository, Request $request): Response
    {

        $game= $gameRepository->findOneById($id);
        $cart->add($game);

        $this->addFlash(
            "success",
            "Produit ajouté au panier."
        );

        return $this->redirect($request->headers->get('referer')

        );
    }

    #[Route('/cart/decrease/{id}', name: 'app_cart_decrease')]
    public function decrease($id,Cart $cart): Response
    {

        $cart->decrease($id);

        $this->addFlash(
            "success",
            "Produit supprimé."
        );

        return $this->redirectToRoute('app_cart'

        );
    }

    #[Route('/cart/remove', name: 'app_cart_remove')]
    public function remove(Cart $cart): Response
    {

        $cart->remove();
        $this->addFlash(
            "danger",
            "Votre panier a bien été vidé."
        );

        return $this->redirectToRoute('app_home');
    }


}

