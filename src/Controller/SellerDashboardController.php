<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\OrderRepository;


class SellerDashboardController extends AbstractController
{

    #[Route('/seller/dashboard', name: 'app_seller_dashboard')]
    public function index(OrderRepository $orderRepository): Response
    {
        $user = $this->getUser();
        $isSeller = $user->getRoles();
        $isSeller = in_array('ROLE_SELLER', $isSeller);

        if (!$isSeller) {
            return $this->redirectToRoute('app_home');
        }

        $seller = $user;
        $store= $seller->getStore();

        $orders = $orderRepository->findBy([
        'pickUpStore' => $store,
         ]);


        return $this->render('seller_dashboard/index.html.twig', [
            'orders' => $orders,
            'store' => $store,
            'controller_name' => 'Espace Vendeur',
        ]);
    }
    #[Route('/seller/order/{id_order}', name: 'app_seller_order', methods: ["GET"])]

    public function getOrderView($id_order, OrderRepository $orderRepository, EntityManagerInterface $entityManager): Response
    {

        $order = $orderRepository->findOneBy([
            'id' => $id_order
        ]);

        if (!$order) {
            return $this->redirectToRoute('app_seller_dashboard');
        }

        return $this->render('seller_dashboard/order.html.twig', [
            'order' => $order,
        ]);
    }

    #[Route('/seller/order/{id_order}/state{state}', name: 'app_seller_order_update')]
    public function setOrderState ($id_order, $state, OrderRepository $orderRepository, EntityManagerInterface $entityManager): Response
    {
       $order = $orderRepository->findOneBy([
            'id' => $id_order
        ]);

        if (!$order) {
            return $this->redirectToRoute('app_seller_dashboard');
        }

        $order->setState($state);
        $entityManager->persist($order);
        $entityManager->flush();
        $this->addFlash('success', "Statut correctement modifié.");

        return $this->redirectToRoute('app_seller_order', ['id_order' => $id_order]);
    }
}
