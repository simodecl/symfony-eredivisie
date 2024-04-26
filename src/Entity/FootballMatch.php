<?php

namespace App\Entity;

use App\Repository\FootballMatchRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Defines the properties of the FootballMatch entity.
 */
#[ORM\Entity(repositoryClass: FootballMatchRepository::class)]
class FootballMatch {
  #[ORM\Id]
  #[ORM\GeneratedValue]
  #[ORM\Column]
  private ?int $id = NULL;

  #[ORM\Column]
  private ?int $matchday = NULL;

  #[ORM\Column(length: 255, nullable: TRUE)]
  private ?string $date = NULL;

  #[ORM\Column(length: 255, nullable: TRUE)]
  private ?string $status = NULL;

  #[ORM\ManyToOne(targetEntity: Team::class)]
  private ?Team $homeTeam = NULL;

  #[ORM\ManyToOne(targetEntity: Team::class)]
  private ?Team $awayTeam = NULL;

  #[ORM\Column(nullable: TRUE)]
  private ?int $homeScore = NULL;

  #[ORM\Column(nullable: TRUE)]
  private ?int $awayScore = NULL;

  #[ORM\Column]
  private ?int $externalId = NULL;

  #[ORM\Column]
  private ?int $currentMatchday = null;

  /**
   * Get the football match ID.
   *
   * @return int|null
   *   The football match ID.
   */
  public function getId(): ?int {
    return $this->id;
  }

  /**
   * Get the matchday.
   *
   * @return int|null
   *   The matchday.
   */
  public function getMatchday(): ?int {
    return $this->matchday;
  }

  /**
   * Set the matchday.
   *
   * @param int $matchday
   *   The matchday.
   */
  public function setMatchday(int $matchday): static {
    $this->matchday = $matchday;

    return $this;
  }

  /**
   * Get the date.
   *
   * @return string|null
   *   The date.
   */
  public function getDate(): ?string {
    return $this->date;
  }

  /**
   * Set the date.
   *
   * @param string|null $date
   *   The date.
   */
  public function setDate(?string $date): static {
    $this->date = $date;

    return $this;
  }

  /**
   * Get the status.
   *
   * @return string|null
   *   The status.
   */
  public function getStatus(): ?string {
    return $this->status;
  }

  /**
   * Set the status.
   *
   * @param string|null $status
   *   The status.
   */
  public function setStatus(?string $status): static {
    $this->status = $status;

    return $this;
  }

  /**
   * Get the home team.
   *
   * @return \App\Entity\Team|null
   *   The home team.
   */
  public function getHomeTeam(): ?Team {
    return $this->homeTeam;
  }

  /**
   * Set the home team.
   *
   * @param \App\Entity\Team|null $homeTeam
   *   The home team.
   */
  public function setHomeTeam(?Team $homeTeam): static {
    $this->homeTeam = $homeTeam;

    return $this;
  }

  /**
   * Get the away team.
   *
   * @return \App\Entity\Team|null
   *   The away team.
   */
  public function getAwayTeam(): ?Team {
    return $this->awayTeam;
  }

  /**
   * Set the away team.
   *
   * @param \App\Entity\Team|null $awayTeam
   *   The away team.
   */
  public function setAwayTeam(?Team $awayTeam): static {
    $this->awayTeam = $awayTeam;

    return $this;
  }

  /**
   * Get the home score.
   *
   * @return int|null
   *   The home score.
   */
  public function getHomeScore(): ?int {
    return $this->homeScore;
  }

  /**
   * Set the home score.
   *
   * @param int|null $homeScore
   *   The home score.
   */
  public function setHomeScore(?int $homeScore): static {
    $this->homeScore = $homeScore;

    return $this;
  }

  /**
   * Get the away score.
   *
   * @return int|null
   *   The away score.
   */
  public function getAwayScore(): ?int {
    return $this->awayScore;
  }

  /**
   * Set the away score.
   *
   * @param int|null $awayScore
   *   The away score.
   */
  public function setAwayScore(?int $awayScore): static {
    $this->awayScore = $awayScore;

    return $this;
  }

  /**
   * Get the external ID.
   *
   * @return int|null
   *   The external ID.
   */
  public function getExternalId(): ?int {
      return $this->externalId;
  }

  /**
   * Set the external ID.
   *
   * @param int $externalId
   *   The external ID.
   */
  public function setExternalId(int $externalId): static {
      $this->externalId = $externalId;

      return $this;
  }

  /**
   * Get the current matchday.
   *
   * @return int|null
   *   The current matchday.
   */
  public function getCurrentMatchday(): ?int {
      return $this->currentMatchday;
  }

  /**
   * Set the current matchday.
   *
   * @param int $currentMatchday
   *   The current matchday.
   */
  public function setCurrentMatchday(int $currentMatchday): static {
      $this->currentMatchday = $currentMatchday;

      return $this;
  }

}
