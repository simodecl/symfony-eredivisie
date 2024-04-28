<?php

namespace App\Command;

use App\Entity\Standing;
use App\Repository\StandingRepository;
use App\Repository\TeamRepository;
use App\Service\FootballDataApiService;
use App\Service\FootballDataApiValidator;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * A console command to get the Eredivisie standings from the Football Data API.
 */
#[AsCommand(
    name: 'app:get-standings',
    description: 'Get the Eredivisie standings from the Football Data API.',
)]
class GetStandingsCommand extends Command {

  /**
   * GetStandingsCommand constructor.
   *
   * @param \Doctrine\ORM\EntityManagerInterface $entityManager
   *   The entity manager.
   * @param \App\Repository\TeamRepository $teams
   *   The team repository.
   * @param \App\Repository\StandingRepository $standings
   *   The standing repository.
   * @param \App\Service\FootballDataApiService $footballDataApiService
   *   The Football Data API service.
   * @param \App\Service\FootballDataApiValidator $footballDataApiValidator
   *   The Football Data API validator.
   * @param \Psr\Log\LoggerInterface $logger
   *   The logger.
   */
  public function __construct(
    private readonly EntityManagerInterface $entityManager,
    private readonly TeamRepository $teams,
    private readonly StandingRepository $standings,
    private readonly FootballDataApiService $footballDataApiService,
    private readonly FootballDataApiValidator $footballDataApiValidator,
    private readonly LoggerInterface $logger
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
      $data = $this->footballDataApiService->getEredivisieStandings();
    }
    catch (\Exception $e) {
      $io->error('An error occurred while trying to fetch the Eredivisie standings from the Football Data API.');
      $io->error($e->getMessage());
      $this->logger->error('An error occurred while trying to fetch the Eredivisie standings from the Football Data API: {error}', ['error' => $e->getMessage()]);

      return Command::FAILURE;
    }

    if (empty($data) || !isset($data['standings'][0]['table'])) {
      $io->error('No standings data was returned by the Football Data API.');
      $this->logger->error('No standings data was returned by the Football Data API.');

      return Command::FAILURE;
    }

    foreach ($data['standings'][0]['table'] as $standingData) {
      // Validate the standing data.
      $violations = $this->footballDataApiValidator->validateStanding($standingData);

      // Abort command because one of the standings contains invalid data.
      if (count($violations) > 0) {
        $io->error(sprintf('Aborting command: The standings data for position %s contains invalid data: %s', $standingData['position'], $violations));
        $this->logger->error('Aborting command: The standings data for position {position} contains invalid data: {violations}', ['position' => $standingData['position'], 'violations' => $violations]);

        return Command::FAILURE;
      }

      // Create or update the position.
      $standing = $this->standings->findOneBy(['position' => $standingData['position']]);

      if (!$standing) {
        $standing = new Standing();
      }

      $standing->setPosition($standingData['position']);
      $standing->setTeam($this->teams->findOneBy(['externalId' => $standingData['team']['id']]));
      $standing->setPlayedGames($standingData['playedGames']);
      $standing->setWon($standingData['won']);
      $standing->setDraw($standingData['draw']);
      $standing->setLost($standingData['lost']);
      $standing->setPoints($standingData['points']);
      $standing->setGoalsFor($standingData['goalsFor']);
      $standing->setGoalsAgainst($standingData['goalsAgainst']);
      $this->entityManager->persist($standing);
    }

    $this->entityManager->flush();

    $io->success(sprintf('Succesfully created/updated %s standings.', count($data['standings'][0]['table'])));
    $this->logger->info('Succesfully created/updated {standings} standings.', ['standings' => count($data['standings'][0]['table'])]);

    return Command::SUCCESS;
  }

}
