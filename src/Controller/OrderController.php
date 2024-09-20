<?php

namespace App\Controller;

use App\Class\Cart;
use App\Entity\Order;
use App\Entity\OrderDetail;
use App\Form\OrderType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class OrderController extends AbstractController

{
    #[Route('/order/pickup', name: 'app_order')]
    public function index(): Response
    {
        $form = $this->createForm(OrderType::class, null, [
            'action' => $this->generateUrl('app_order_summary')
        ]);

        return $this->render('order/index.html.twig', [
            'pickupForm' => $form->createView(),
        ]);
    }

    #[Route('/order/summary', name: 'app_order_summary')]
    public function add(Request $request, Cart $cart, EntityManagerInterface $entityManager): Response

    {
        if ($request->getMethod() != 'POST') {
            return $this->redirectToRoute('app_cart');
        }

        $games= $cart->getCart();

        $form = $this->createForm(OrderType::class, null,);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){


            $order = new Order();
            $order->setUser($this->getUser());
            $order->setCreatedAt(new \DateTimeImmutable());
            $order->setState(1);

            $order->setStoreName($form->get('store')->getData()->getName());
            $order->setPickUpDate($form->get('pickupDate')->getData());

            $addressObj = $order->getUser();

            $address = $addressObj->getFirstname().' '.$addressObj->getLastname().'<br/>';
            $address .= $addressObj->getAddress().'<br/>';
            $address .= $addressObj->getPostal().' '.$addressObj->getCity().'<br/>';
            $address .= $addressObj->getEmail().' ';

            $order->setBillingAddress($address);

            foreach($games as $game){

                $orderDetail = new OrderDetail();
                $orderDetail->setGameName(($game['object']->getName()));
                $orderDetail->setGameImage($game['object']->getImage());
                $orderDetail->setGamePrice($game['object']->getPrice());
                $orderDetail->setGameQuantity($game['qty']);
                $order->addOrderDetail($orderDetail);
            }
            $entityManager->persist($order);
            $entityManager->flush();
        }

        return $this->render('order/summary.html.twig', [
            'choices' => $form ->getData(),
            'cart'=> $games,
            /* TODO : voir pourquoi la variable order ci dessous n'est pas reconnue */
            /*'order' => $order,*/
            'total'=>$cart->getTotal(),
        ]);
    }
}
