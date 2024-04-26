<?php

namespace App\Command;

use App\Entity\FootballMatch;
use App\Repository\FootballMatchRepository;
use App\Repository\TeamRepository;
use App\Service\FootballDataApiService;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * A console command to get the Eredivisie matches from the Football Data API.
 */
#[AsCommand(
    name: 'app:get-matches',
    description: 'Get the Eredivisie matches from the Football Data API.',
)]
class GetMatchesCommand extends Command {

  /**
   * GetMatchesCommand constructor.
   */
  public function __construct(
    private readonly EntityManagerInterface $entityManager,
    private readonly TeamRepository $teams,
    private readonly FootballMatchRepository $footballMatches,
    private readonly FootballDataApiService $footballDataApiService,
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
      $data = $this->footballDataApiService->getEredivisieMatches();
    }
    catch (\Exception $e) {
      $io->error('An error occurred while trying to fetch the Eredivisie matches from the Football Data API.');
      $io->error($e->getMessage());
      $this->logger->error('An error occurred while trying to fetch the Eredivisie matches from the Football Data API: {error}', ['error' => $e->getMessage()]);

      return Command::FAILURE;
    }

    if (empty($data) || !isset($data['matches'])) {
      $io->error('No matches data was returned by the Football Data API.');
      $this->logger->error('No matches data was returned by the Football Data API.');

      return Command::FAILURE;
    }

    // Store match ids to clean up orphaned entities later.
    $footballMatchIds = [];

    foreach ($data['matches'] as $footballMatchData) {
      // Create or update the footballMatch.
      $footballMatch = $this->footballMatches->findOneBy(['externalId' => $footballMatchData['id']]);
      $footballMatchIds[] = $footballMatchData['id'];

      if (!$footballMatch) {
        $footballMatch = new FootballMatch();
        $footballMatch->setExternalId($footballMatchData['id']);
      }

      $footballMatch->setDate($footballMatchData['utcDate']);
      $footballMatch->setStatus($footballMatchData['status'] ?? '');
      $footballMatch->setMatchday($footballMatchData['matchday']);
      $footballMatch->setCurrentMatchday($footballMatchData['season']['currentMatchday']);
      $footballMatch->setHomeTeam($this->teams->findOneBy(['externalId' => $footballMatchData['homeTeam']['id']]));
      $footballMatch->setAwayTeam($this->teams->findOneBy(['externalId' => $footballMatchData['awayTeam']['id']]));
      $footballMatch->setHomeScore($footballMatchData['score']['fullTime']['home'] ?? NULL);
      $footballMatch->setAwayScore($footballMatchData['score']['fullTime']['away'] ?? NULL);
      $this->entityManager->persist($footballMatch);
    }

    $this->entityManager->flush();

    $io->success(sprintf('Succesfully created/updated %s football matches.', count($footballMatchIds)));
    $this->logger->info('Succesfully created/updated {footballMatches} football matches.', ['footballMatches' => count($footballMatchIds)]);

    // Clean up orphaned entities.
    $footballMatchesToDelete = $this->footballMatches->findAllExcept($footballMatchIds);

    foreach ($footballMatchesToDelete as $footballMatch) {
      $this->entityManager->remove($footballMatch);
    }

    $this->entityManager->flush();

    $io->success(sprintf('Succesfully removed %s football matches.', count($footballMatchesToDelete)));
    $this->logger->info('Succesfully removed {footballMatches} football matches.', ['footballMatches' => count($footballMatchesToDelete)]);

    return Command::SUCCESS;
  }

}
