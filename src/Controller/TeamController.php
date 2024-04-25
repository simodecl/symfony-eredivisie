<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

/**
 * Controller used to display teams.
 */
class TeamController extends AbstractController {

  /**
   * Display the list of teams.
   *
   * @return \Symfony\Component\HttpFoundation\Response
   *   A Symfony response object.
   */
  #[Route('/teams', name: 'app_teams')]
  public function index(): Response {
    return $this->render('team/index.html.twig', [
      'controller_name' => 'TeamController',
    ]);
  }

}
