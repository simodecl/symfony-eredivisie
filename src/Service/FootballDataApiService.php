<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * A service to interact with the Football Data API.
 */
class FootballDataApiService {

  /**
   * The HTTP client.
   *
   * @var \Symfony\Contracts\HttpClient\HttpClientInterface
   */
  private HttpClientInterface $client;

  /**
   * FootballDataApiService constructor.
   *
   * @param \Symfony\Contracts\HttpClient\HttpClientInterface $client
   *   The HTTP client.
   *
   * @throws \Exception
   */
  public function __construct(HttpClientInterface $client) {
    if (!isset($_ENV['FOOTBALL_DATA_API_TOKEN'])) {
      throw new \Exception('The FOOTBALL_DATA_API_TOKEN environment variable is not set in .env.');
    }

    if (!isset($_ENV['FOOTBALL_DATA_API_BASE_URI'])) {
      throw new \Exception('The FOOTBALL_DATA_API_BASE_URI environment variable is not set in .env.');
    }

    $this->client = $client->withOptions([
      'base_uri' => $_ENV['FOOTBALL_DATA_AUTH_TOKEN'],
      'headers' => [
        'X-Auth-Token' => $_ENV['FOOTBALL_DATA_AUTH_TOKEN'],
      ],
    ]);
  }

  /**
   * Get the info of the current Eredivisie teams from the Football Data API.
   *
   * @return array
   *   An array of Eredivisie teams.
   *
   * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
   * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
   * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
   * @throws \Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface
   * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
   */
  public function getEredivisieTeams(): array {
    $response = $this->client->request('GET', '/competitions/DED/teams');
    $parsedResponse = $response->toArray();

    return $parsedResponse['value'];
  }

}
