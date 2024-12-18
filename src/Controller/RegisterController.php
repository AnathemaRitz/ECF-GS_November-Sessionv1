<?php
namespace App\Controller;
use App\Entity\Customer;
use App\Class\Mail;

use App\Form\RegisterUserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class RegisterController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = new Customer();
        $form = $this->createForm(RegisterUserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash(
                'success',
                "Votre compte est correctement créé, vous pouvez vous connecter."
            );

            $mail = new Mail();
            $vars=[
                'firstname' => $user->getFirstname(),
                ];
            $mail->send($user->getEmail(), $user->getFirstname().' '.$user->getLastname(), 'Bienvenue sur Gamestore', 'welcome.html', $vars);

           return $this->redirectToRoute('app_login');
        }
        return $this->render('register/index.html.twig', [
            'registerForm' => $form->createView()]);
    }
}

