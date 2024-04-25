<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * Controller used to manage security.
 */
class SecurityController extends AbstractController {

  /**
   * Display the login form.
   *
   * @param \Symfony\Component\Security\Http\Authentication\AuthenticationUtils $authenticationUtils
   *   The authentication utils service.
   *
   * @return \Symfony\Component\HttpFoundation\Response
   *   A Symfony response object.
   */
  #[Route(path: '/login', name: 'app_login')]
  public function login(AuthenticationUtils $authenticationUtils): Response {
    if ($this->getUser()) {
      return $this->redirectToRoute('homepage');
    }

    // Get the login error if there is one.
    $error = $authenticationUtils->getLastAuthenticationError();
    // Last username entered by the user.
    $lastUsername = $authenticationUtils->getLastUsername();

    return $this->render('security/login.html.twig', [
      'last_username' => $lastUsername,
      'error' => $error,
    ]);
  }

  /**
   * Log the user out.
   *
   * @throws \LogicException
   */
  #[Route(path: '/logout', name: 'app_logout')]
  public function logout(): void {
    throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
  }

}
