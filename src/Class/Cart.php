<?php

namespace App\Class;

use Symfony\Component\HttpFoundation\RequestStack;

class Cart
{
    public function __construct(private RequestStack $requestStack)
    {

    }


    public function add($game)
    {

        $cart=$this->getCart();
        if (isset($cart[$game->getId()])) {
            $cart[$game->getId()] = [
                'object' => $game,
                'qty' => $cart[$game->getId()]['qty'] + 1
            ];


        } else {
            $cart[$game->getId()] = [
                'object'=>$game,
                'qty'=>1
            ];
        }
        $this->requestStack->getSession()->set('cart', $cart);

    }


    public function decrease($id)
    {

        $cart=$this->getCart();
        if ($cart[$id]['qty'] >1){
            $cart[$id]['qty'] =$cart[$id]['qty']-1;
        }

        else {
            unset($cart[$id]);
        }


        $this->requestStack->getSession()->set('cart', $cart);

    }


    public function fullQuantity()
    {
        $cart=$this->getCart();
        $quantity=0;

        if(!isset($cart)){
            return $quantity;
        }

        foreach ($cart as $game){
            $quantity = $quantity+$game['qty'];
        }
        return $quantity;
    }


    public function getTotal()
    {   $cart=$this->getCart();
        $price=0;

        if(!isset($cart)){
            return $price;
        }

        foreach ($cart as $game){
            $price = $price+($game['object']->getPrice()*$game['qty']);
        }
        return $price;
    }


    public function remove()
    {

        return $this->requestStack->getSession()->remove('cart');
    }

    public function getCart()
    {
        return $this->requestStack->getSession()->get('cart');
    }
}






