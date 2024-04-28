<?php

namespace App\Controller;

use App\Entity\Team;
use App\Entity\User;
use App\Repository\FootballMatchRepository;
use App\Repository\PlayerRepository;
use App\Repository\TeamRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

/**
 * Controller used to display teams.
 */
class TeamController extends AbstractController {

  /**
   * Display the list of teams.
   *
   * @param \App\Repository\TeamRepository $teamRepo
   *   The team repository.
   *
   * @return \Symfony\Component\HttpFoundation\Response
   *   A Symfony response object.
   */
  #[Route('/teams', name: 'teams')]
  public function index(TeamRepository $teamRepo): Response {
    $teams = $teamRepo->findBy([], ['name' => 'ASC']);

    return $this->render('team/index.html.twig', [
      'teams' => $teams,
    ]);
  }

  /**
   * Display the details of a team.
   *
   * @param \App\Entity\Team $team
   *   The team.
   * @param \App\Repository\PlayerRepository $playerRepo
   *   The player repository.
   */
  #[Route('/teams/{id}', name: 'team_detail', requirements: ['id' => Requirement::POSITIVE_INT], methods: ['GET'])]
  public function teamDetail(Team $team, PlayerRepository $playerRepo, FootballMatchRepository $footballMatchRepo): Response {
    return $this->render('team/detail.html.twig', [
      'team' => $team,
      'coach' => $team->getCoach(),
      'players' => $playerRepo->findBy(['team' => $team->getId()]),
      'matches' => $footballMatchRepo->findAllByTeamId($team->getId()),
    ]);
  }

  /**
   * Follow or unfollow a team.
   *
   * @param \App\Entity\Team $team
   *   The team.
   * @param \App\Entity\User $user
   *   The current user.
   * @param \Doctrine\ORM\EntityManagerInterface $entityManager
   *   The entity manager.
   *
   * @return \Symfony\Component\HttpFoundation\Response
   */
  #[Route('/teams/{team}/follow', name: 'team_follow', requirements: ['team' => Requirement::POSITIVE_INT], methods: ['GET'])]
  public function follow(Team $team, #[CurrentUser] User $user, EntityManagerInterface $entityManager): Response {
    $user->addFollowedTeam($team);
    $entityManager->flush();
    $this->addFlash('success', ['You are now following ' . $team->getName() . '.']);

    return $this->redirectToRoute('teams');
  }

  /**
   * Unfollow a team.
   *
   * @param \App\Entity\Team $team
   *   The team.
   * @param \App\Entity\User $user
   *   The current user.
   * @param \Doctrine\ORM\EntityManagerInterface $entityManager
   *   The entity manager.
   */
  #[Route('/teams/{team}/unfollow', name: 'team_unfollow', requirements: ['team' => Requirement::POSITIVE_INT], methods: ['GET'])]
  public function unfollow(Team $team, #[CurrentUser] User $user, EntityManagerInterface $entityManager): Response {
    $user->removeFollowedTeam($team);
    $entityManager->flush();
    $this->addFlash('success', ['You are no longer following ' . $team->getName() . '.']);

    return $this->redirectToRoute('teams');
  }

}
