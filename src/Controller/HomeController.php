<?php

namespace App\Controller;

use App\Repository\FootballMatchRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

/**
 * Controller used to manage the homepage.
 */
class HomeController extends AbstractController {

  /**
   * Display the homepage.
   */
  #[Route('/', name: 'homepage')]
  public function index(FootballMatchRepository $footballMatchRepo): Response {
    $followedTeams = [];
    $latestResults = [];

    if ($this->getUser()) {
      $followedTeams = $this->getUser()->getFollowedTeams();
    }

    if (!empty($followedTeams)) {
      // Get the latest result for the followed teams.
      $latestResults = $footballMatchRepo->findLatestResults($followedTeams);
    }

    return $this->render('home/index.html.twig', [
      'latest_results' => $latestResults,
    ]);
  }

}
