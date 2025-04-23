<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use App\Service\RegisterService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class RegisterController extends AbstractController
{
    public function __construct(
        private readonly RegisterService $registerService
    )
    {}

    #[Route('/register', name: 'app_register')]
    public function addUser(Request $request): Response
    {
        $user = new User;
        $registerForm = $this->createForm(RegisterType::class, $user);
        $registerForm->handleRequest($request);

        // Test si le formulaire est soumis et valide
        if($registerForm->isSubmitted() && $registerForm->isValid()) {
            try {
                $message = "";
                $type = "";
                if($this->registerService->saveUser($user)) {
                    $message = "L'utilisateur " . $user->getFirstname() ." ". $user->getLastname() . " a été ajouté ";
                    $type = "success";
                }
            } catch (\Exception $e) {
                $message = $e->getMessage();
                $type = "danger";
            }
            $this->addFlash($type, $message);
        }

        return $this->render('register/register.html.twig', [
            'registerForm' => $registerForm,
        ]);
    }
}
