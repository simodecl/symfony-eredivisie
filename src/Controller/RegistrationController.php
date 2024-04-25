<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\EmailVerifier;
use App\Security\LoginFormAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

/**
 * Controller used to manage registration.
 */
class RegistrationController extends AbstractController {

  /**
   * RegistrationController constructor.
   *
   * @param \App\Security\EmailVerifier $emailVerifier
   *   The email verifier service.
   */
  public function __construct(private readonly EmailVerifier $emailVerifier) {
  }

  /**
   * Register a new user.
   *
   * @param \Symfony\Component\HttpFoundation\Request $request
   *   The request object.
   * @param \Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface $userPasswordHasher
   *   The password hasher service.
   * @param \Symfony\Bundle\SecurityBundle\Security $security
   *   The security service.
   * @param \Doctrine\ORM\EntityManagerInterface $entityManager
   *   The entity manager.
   *
   * @return \Symfony\Component\HttpFoundation\Response
   *   A Symfony response object.
   */
  #[Route('/register', name: 'app_register')]
  public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, Security $security, EntityManagerInterface $entityManager): Response {
    $user = new User();
    $form = $this->createForm(RegistrationFormType::class, $user);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      // Encode the plain password.
      $user->setPassword(
            $userPasswordHasher->hashPassword(
                $user,
                $form->get('plainPassword')->getData()
            )
        );

      $entityManager->persist($user);
      $entityManager->flush();

      // Generate a signed url and email it to the user.
      $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
            (new TemplatedEmail())
              ->from(new Address('decloedt.simon@gmail.com', 'Eredivisie Dashboard'))
              ->to($user->getEmail())
              ->subject('Please Confirm your Email')
              ->htmlTemplate('registration/confirmation_email.html.twig')
        );

      // Do anything else you need here, like send an email.
      return $security->login($user, LoginFormAuthenticator::class, 'main');
    }

    return $this->render('registration/register.html.twig', [
      'registrationForm' => $form,
    ]);
  }

  /**
   * Verify a user's email address.
   *
   * @param \Symfony\Component\HttpFoundation\Request $request
   *   The request object.
   * @param \Symfony\Contracts\Translation\TranslatorInterface $translator
   *   The translator service.
   *
   * @return \Symfony\Component\HttpFoundation\Response
   *   A Symfony response object.
   */
  #[Route('/verify/email', name: 'app_verify_email')]
  public function verifyUserEmail(Request $request, TranslatorInterface $translator): Response {
    $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

    // Validate email confirmation link, sets User::isVerified=true and
    // persists.
    try {
      $this->emailVerifier->handleEmailConfirmation($request, $this->getUser());
    }
    catch (VerifyEmailExceptionInterface $exception) {
      $this->addFlash('verify_email_error', $translator->trans($exception->getReason(), [], 'VerifyEmailBundle'));

      return $this->redirectToRoute('app_register');
    }

    $this->addFlash('success', 'Your email address has been verified.');

    return $this->redirectToRoute('app_register');
  }

}
