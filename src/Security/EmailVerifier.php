<?php

namespace App\Security;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;

/**
 * The email verifier.
 */
class EmailVerifier {

  /**
   * EmailVerifier constructor.
   *
   * @param \SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface $verifyEmailHelper
   *   The verify email helper.
   * @param \Symfony\Component\Mailer\MailerInterface $mailer
   *   The mailer.
   * @param \Doctrine\ORM\EntityManagerInterface $entityManager
   *   The entity manager.
   */
  public function __construct(
        private VerifyEmailHelperInterface $verifyEmailHelper,
        private MailerInterface $mailer,
        private EntityManagerInterface $entityManager
    ) {
  }

  /**
   * Send the email confirmation.
   *
   * @param string $verifyEmailRouteName
   *   The verify email route name.
   * @param \Symfony\Component\Security\Core\User\UserInterface $user
   *   The user.
   * @param \Symfony\Bridge\Twig\Mime\TemplatedEmail $email
   *   The email.
   *
   * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
   */
  public function sendEmailConfirmation(string $verifyEmailRouteName, UserInterface $user, TemplatedEmail $email): void {
    $signatureComponents = $this->verifyEmailHelper->generateSignature(
          $verifyEmailRouteName,
          $user->getId(),
          $user->getEmail()
      );

    $context = $email->getContext();
    $context['signedUrl'] = $signatureComponents->getSignedUrl();
    $context['expiresAtMessageKey'] = $signatureComponents->getExpirationMessageKey();
    $context['expiresAtMessageData'] = $signatureComponents->getExpirationMessageData();

    $email->context($context);

    $this->mailer->send($email);
  }

  /**
   * Handle the email confirmation.
   *
   * @param \Symfony\Component\HttpFoundation\Request $request
   *   The request.
   * @param \Symfony\Component\Security\Core\User\UserInterface $user
   *   The user.
   *
   * @throws \SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface
   */
  public function handleEmailConfirmation(Request $request, UserInterface $user): void {
    $this->verifyEmailHelper->validateEmailConfirmationFromRequest($request, $user->getId(), $user->getEmail());

    $user->setVerified(TRUE);

    $this->entityManager->persist($user);
    $this->entityManager->flush();
  }

}
