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
    public function summary(Request $request, Cart $cart, EntityManagerInterface $entityManager): Response

    {
        if ($request->getMethod() != 'POST') {
            return $this->redirectToRoute('app_cart');
        }

        $games= $cart->getCart();

        $form = $this->createForm(OrderType::class, null,);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $order = new Order();
            $order->setCustomer($this->getUser());
            $order->setCreatedAt(new \DateTimeImmutable());
            $order->setState(1);

            $order->setPickUpDate($form->get('pickupDate')->getData());
            $order->setPickUpStore($form->get('store')->getData());
            /*dd($form->get('store')->getData()->getId());*/


            $addressObj = $order->getCustomer();

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
            $session = $request->getSession();
            $session->set('order', $order);
            /*dd($order) ;*/
        }

        return $this->render('order/summary.html.twig', [
                'choices' => $form->getData(),
                'cart' => $games,
                'total' => $cart->getTotal(),
            ]);
    }

    #[Route('/order/validation', name: 'app_order_validation')]
    public function add(Request $request, Cart $cart,  EntityManagerInterface $entityManager): Response
    {
        $session = $request->getSession();
        $order = $session->get('order');
        $games = $cart->getCart();


        if ($order) {

            $user = $this->getUser();

            if ($user) {
                $order->setCustomer($user);
            }

            foreach($games as $game){
                $gameObject = $entityManager->find(get_class($game['object']), $game['object']->getId());
                $gameAvailability = $gameObject->getStock();
                $gameStock = $gameAvailability - $game['qty'];

                if ($gameStock < 0) {
                    $this->addFlash('error',  $gameObject->getName().'.n\'est plus en stock. Veuillez mettre à jour la quantité désirée.');
                    return $this->redirectToRoute('app_cart');
                }

                $gameObject->setStock($gameStock);

            }

            $entityManager->persist($order);
            $entityManager->flush();

            $session->remove('cart');
            $session->remove('order');


            return $this->render('order/confirmation.html.twig');
        }

        return $this->redirectToRoute('app_order');
    }

}
