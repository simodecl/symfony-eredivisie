<?php

namespace App\Controller;

use App\Repository\StandingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

/**
 * Controller used to display the standing of the teams.
 */
class StandingController extends AbstractController {

  /**
   * Display the list of standings.
   *
   * @param \App\Repository\StandingRepository $standingRepo
   *   The standing repository.
   *
   * @return \Symfony\Component\HttpFoundation\Response
   *   A Symfony response object.
   */
  #[Route('/standings', name: 'standings')]
  public function index(StandingRepository $standingRepo): Response {
    $standings = $standingRepo->findBy([], ['position' => 'ASC']);

    return $this->render('standing/index.html.twig', [
      'standings' => $standings,
    ]);
  }

}
