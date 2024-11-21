<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class ErrorRouteTestController extends AbstractController
{
    #[Route('/error404', name: 'error_404')]
    public function error404(): Response
    {
        throw new NotFoundHttpException('page introuvable.');
    }

    #[Route('/error403', name: 'error_403')]
    public function error403(): Response
    {
        throw new AccessDeniedException('You do not have access to this page.');
    }

   #[Route('/error500', name: 'error_500')]
    public function error500(): Response
    {
        throw new \Exception ('This is a test 500 error.');
    }
}
