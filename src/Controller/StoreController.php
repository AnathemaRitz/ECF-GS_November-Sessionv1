<?php

namespace App\Controller;

use App\Repository\StoreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class StoreController extends AbstractController
{
    #[Route('/store/{slug}', name: 'app_store')]
    public function index($slug, StoreRepository $storeRepository): Response
    {
        $store=$storeRepository->findOneBy(['slug'=>$slug]);
        if(!$store) {
            return $this->redirectToRoute('app_home');
        }

        return $this->render('store/index.html.twig', [
            'store' => $store,
        ]);
    }
}
