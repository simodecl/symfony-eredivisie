<?php

namespace App\Command;

use App\Entity\Coach;
use App\Entity\Player;
use App\Entity\Team;
use App\Repository\CoachRepository;
use App\Repository\PlayerRepository;
use App\Repository\TeamRepository;
use App\Service\FootballDataApiService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * A console command to get the Eredivisie teams from the Football Data API.
 */
#[AsCommand(
    name: 'app:get-teams',
    description: 'Get the current Eredivisie teams from the Football Data API, including their coaches and players.',
)]
class GetTeamsCommand extends Command {

  /**
   * GetTeamsCommand constructor.
   */
  public function __construct(
    private readonly EntityManagerInterface $entityManager,
    private readonly TeamRepository $teams,
    private readonly CoachRepository $coaches,
    private readonly PlayerRepository $players,
    private readonly FootballDataApiService $footballDataApiService
  ) {
    parent::__construct();
  }

  /**
   * {@inheritdoc}
   */
  protected function configure(): void {
  }

  /**
   * {@inheritdoc}
   */
  protected function execute(InputInterface $input, OutputInterface $output): int {
    $io = new SymfonyStyle($input, $output);

    try {
      $data = $this->footballDataApiService->getEredivisieTeams();
    }
    catch (\Exception $e) {
      $io->error('An error occurred while trying to fetch the Eredivisie teams from the Football Data API.');
      $io->error($e->getMessage());

      return Command::FAILURE;
    }

    if (empty($data) || !isset($data['teams'])) {
      $io->error('No data was returned by the Football Data API.');

      return Command::FAILURE;
    }

    // Store team, coach and player Ids to clean up orphaned entities later.
    $teamIds = [];
    $coachIds = [];
    $playerIds = [];

    foreach ($data['teams'] as $teamData) {
      // Create or update the team.
      $team = $this->teams->findOneBy(['externalId' => $teamData['id']]);
      $teamIds[] = $teamData['id'];

      if (!$team) {
        $team = new Team();
        $team->setExternalId($teamData['id']);
      }

      $team->setName($teamData['name']);
      $team->setCrest($teamData['crest'] ?? '');
      $team->setAddress($teamData['address'] ?? '');
      $team->setWebsite($teamData['website'] ?? '');
      $team->setColors($teamData['clubColors'] ?? '');
      $team->setFounded($teamData['founded'] ?? '');
      $team->setVenue($teamData['venue'] ?? '');
      $this->entityManager->persist($team);
      $this->entityManager->flush();

      // Create or update the coach.
      $coachData = $teamData['coach'];

      if (isset($coachData['id'])) {
        $coach = $this->coaches->findOneBy(['externalId' => $coachData['id']]);
        $coachIds[] = $coachData['id'];

        if (!$coach) {
          $coach = new Coach();
          $coach->setExternalId($coachData['id']);
        }

        $coach->setName($coachData['name']);
        $coach->setDateOfBirth($coachData['dateOfBirth'] ?? '');
        $coach->setNationality($coachData['nationality'] ?? '');
        $coach->setTeam($team);
        $this->entityManager->persist($coach);
      }

      foreach ($teamData['squad'] as $playerData) {
        if (!isset($playerData['id'])) {
          continue;
        }

        $player = $this->players->findOneBy(['externalId' => $playerData['id']]);
        $playerIds[] = $playerData['id'];

        if (!$player) {
          $player = new Player();
          $player->setExternalId($playerData['id']);
        }

        $player->setName($playerData['name']);
        $player->setPosition($playerData['position'] ?? '');
        $player->setDateOfBirth($playerData['dateOfBirth'] ?? '');
        $player->setNationality($playerData['nationality'] ?? '');
        $player->setTeam($team);
        $this->entityManager->persist($player);
      }
    }

    $this->entityManager->flush();

    $io->success(sprintf('Succesfully created/updated %s teams, %s coaches and %s players.', count($teamIds), count($coachIds), count($playerIds)));

    return Command::SUCCESS;
  }

}