<?php
namespace App\EventListener;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Session\SessionFactoryInterface;

class AccessDeniedExceptionListener
{
    private $router;
    private $session;

    public function __construct(RouterInterface $router, SessionFactoryInterface $sessionFactory)
    {
        $this->router = $router;
        $this->session = $sessionFactory->createSession();
    }

    public function onKernelException(ExceptionEvent $event)
    {
        $exception=$event->getThrowable();
        if (!$exception instanceof AccessDeniedException) {
            $this->session->getflashBag()->add('error', 'Erreur 403 : Vous n\' avez pas l\'autorisation d\'accéder à cette ressource.');
            $response = new RedirectResponse($this->router->generate('app_account'));
            $event->setResponse($response);
        }
    }

    //TODO : Probablement à cause de la variable session, le message ne s'affiche pas pour un simple visiteur. Quelque chose à régler plutôt avec une règle de Rôle ?
    //TODO : Egalement, le flash message ne se formate pas correctement, il est affiché en brut sur la page.
}

