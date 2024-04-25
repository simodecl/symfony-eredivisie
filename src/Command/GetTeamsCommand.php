<?php

namespace App\Command;

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

    if (empty($data)) {
      $io->error('No data was returned by the Football Data API.');

      return Command::FAILURE;
    }

    $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

    return Command::SUCCESS;
  }

}
