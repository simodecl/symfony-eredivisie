<?php

namespace App\Controller;

use App\Repository\FootballMatchRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;

/**
 * Controller used to manage the football match pages.
 */
#[Route('/matches')]
final class FootballMatchController extends AbstractController {

  /**
   * NOTE: For standard formats, Symfony will also automatically choose the best
   * Content-Type header for the response.
   *
   * See https://symfony.com/doc/current/routing.html#special-parameters
   */
  #[Route('/', name: 'matches', defaults: ['matchday' => '1'], methods: ['GET'])]
  #[Route('/matchday/{matchday}', name: 'matches_paginated', requirements: ['matchday' => Requirement::POSITIVE_INT], methods: ['GET'])]
  #[Cache(smaxage: 10)]
  public function index(Request $request, int $matchday, FootballMatchRepository $footballMatches): Response {
    $lastMatchday = $footballMatches->getLastMatchday();
    $hasPreviousMatchday = $matchday > 1;
    $hasNextMatchday = $matchday < $lastMatchday;

    return $this->render('football_match/index.html.twig', [
      'football_matches' => $footballMatches->findAllByMatchday($matchday),
      'matchday' => $matchday,
      'current_matchday' => $footballMatches->getCurrentMatchday(),
      'has_previous_matchday' => $hasPreviousMatchday,
      'has_next_matchday' => $hasNextMatchday,
    ]);
  }

}
