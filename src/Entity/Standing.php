<?php

namespace App\Entity;

use App\Repository\StandingRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 *  Defines the properties of the Standing entity.
 */
#[ORM\Entity(repositoryClass: StandingRepository::class)]
class Standing {
  #[ORM\Id]
  #[ORM\GeneratedValue]
  #[ORM\Column]
  private ?int $id = NULL;

  #[ORM\Column]
  private ?int $position = NULL;

  #[ORM\OneToOne(inversedBy: 'standing', cascade: ['persist', 'remove'])]
  #[ORM\JoinColumn(nullable: FALSE)]
  private ?Team $team = NULL;

  #[ORM\Column]
  private ?int $playedGames = NULL;

  #[ORM\Column]
  private ?int $won = NULL;

  #[ORM\Column]
  private ?int $draw = NULL;

  #[ORM\Column]
  private ?int $lost = NULL;

  #[ORM\Column]
  private ?int $points = NULL;

  #[ORM\Column]
  private ?int $goalsFor = NULL;

  #[ORM\Column]
  private ?int $goalsAgainst = NULL;

  /**
   * Get the value of id.
   *
   * @return int|null
   *   The value of id.
   */
  public function getId(): ?int {
    return $this->id;
  }

  /**
   * Get the position.
   *
   * @return int|null
   *   The position.
   */
  public function getPosition(): ?int {
    return $this->position;
  }

  /**
   * Set the position.
   *
   * @param int $position
   *   The position.
   */
  public function setPosition(int $position): static {
    $this->position = $position;

    return $this;
  }

  /**
   * Get the team.
   *
   * @return \App\Entity\Team|null
   */
  public function getTeam(): ?Team {
    return $this->team;
  }

  /**
   * Set the team.
   *
   * @param \App\Entity\Team $team
   *   The team.
   */
  public function setTeam(Team $team): static {
    $this->team = $team;

    return $this;
  }

  /**
   * Get the played games.
   *
   * @return int|null
   *   The played games.
   */
  public function getPlayedGames(): ?int {
    return $this->playedGames;
  }

  /**
   * Set the played games.
   *
   * @param int $playedGames
   *   The played games.
   */
  public function setPlayedGames(int $playedGames): static {
    $this->playedGames = $playedGames;

    return $this;
  }

  /**
   * Get the won games.
   *
   * @return int|null
   *   The won games.
   */
  public function getWon(): ?int {
    return $this->won;
  }

  /**
   * Set the won games.
   *
   * @param int $won
   *   The won games.
   */
  public function setWon(int $won): static {
    $this->won = $won;

    return $this;
  }

  /**
   * Get the draw games.
   *
   * @return int|null
   *   The draw games.
   */
  public function getDraw(): ?int {
    return $this->draw;
  }

  /**
   * Set the draw games.
   *
   * @param int $draw
   *   The draw games.
   */
  public function setDraw(int $draw): static {
    $this->draw = $draw;

    return $this;
  }

  /**
   * Get the lost games.
   *
   * @return int|null
   *   The lost games.
   */
  public function getLost(): ?int {
    return $this->lost;
  }

  /**
   * Set the lost games.
   *
   * @param int $lost
   *   The lost games.
   */
  public function setLost(int $lost): static {
    $this->lost = $lost;

    return $this;
  }

  /**
   * Get the points.
   *
   * @return int|null
   *   The points.
   */
  public function getPoints(): ?int {
    return $this->points;
  }

  /**
   * Set the points.
   *
   * @param int $points
   *   The points.
   */
  public function setPoints(int $points): static {
    $this->points = $points;

    return $this;
  }

  /**
   * Get the goals for.
   *
   * @return int|null
   *   The goals for.
   */
  public function getGoalsFor(): ?int {
    return $this->goalsFor;
  }

  /**
   * Set the goals for.
   *
   * @param int $goalsFor
   *   The goals for.
   */
  public function setGoalsFor(int $goalsFor): static {
    $this->goalsFor = $goalsFor;

    return $this;
  }

  /**
   * Get the goals against.
   *
   * @return int|null
   *   The goals against.
   */
  public function getGoalsAgainst(): ?int {
    return $this->goalsAgainst;
  }

  /**
   * Set the goals against.
   *
   * @param int $goalsAgainst
   *   The goals against.
   */
  public function setGoalsAgainst(int $goalsAgainst): static {
    $this->goalsAgainst = $goalsAgainst;

    return $this;
  }

}
