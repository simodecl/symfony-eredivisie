<?php

namespace App\Service;

use Symfony\Component\Validator\Constraints\All;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Optional;
use Symfony\Component\Validator\Constraints\Required;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class FootballDataApiValidator {

  /**
   * The validator.
   *
   * @var \Symfony\Component\Validator\Validator\ValidatorInterface
   */
  private ValidatorInterface $validator;

  public function __construct(ValidatorInterface $validator) {
    $this->validator = $validator;
  }

  /**
   * Validate the data of a football match.
   *
   * @param array $data
   *   The data of the football match.
   *
   * @return \Symfony\Component\Validator\ConstraintViolationListInterface
   *   The list of constraint violations.
   */
  public function validateFootballMatch(array $data): ConstraintViolationListInterface {
    $constraint = new Collection([
      'utcDate' => new Required([
        new NotBlank(),
        new DateTime(['format' => 'Y-m-d\TH:i:s\Z']),
      ]),
      'status' => new Required([
        new Type('string'),
      ]),
      'matchday' => new Required([
        new Type('integer'),
      ]),
      'season' => new Required([
        new Type('array'),
        new Collection([
          'currentMatchday' => new Required([
            new Type('integer'),
          ]),
        ], null, null, TRUE)
      ]),
      'homeTeam' => new Required([
        new Type('array'),
        new Collection([
          'id' => new Required([
            new NotBlank(),
            new Type('integer'),
          ])
        ], null, null, TRUE),
      ]),
      'awayTeam' => new Required([
        new Type('array'),
        new Collection([
          'id' => new Required([
            new NotBlank(),
            new Type('integer'),
          ])
        ], null, null, TRUE),
      ]),
      'score' => new Required([
        new Type('array'),
        new Collection([
          'fullTime' => new Required([
            new Type('array'),
              new Collection([
                'home' => new Required([
                  new Type('integer'),
                ]),
                'away' => new Required([
                  new Type('integer'),
                ]),
              ], null, null, TRUE),
          ]),
        ], null, null, TRUE),
      ]),
    ]);

    return $this->validator->validate($data, $constraint);
  }

  /**
   * Validate the data of a team.
   *
   * @param array $data
   *   The data of a team
   *
   * @return \Symfony\Component\Validator\ConstraintViolationListInterface
   *   The list of constraint violations.
   */
  public function validateTeam(array $data): ConstraintViolationListInterface {
    $constraint = new Collection([
      'id' => new Required([
        new NotBlank(),
        new Type('integer'),
      ]),
      'name' => new Required([
        new NotBlank(),
        new Type('string'),
      ]),
      'crest' => new Optional([
        new Type('string'),
      ]),
      'address' => new Optional([
        new Type('string'),
      ]),
      'website' => new Optional([
        new Type('string'),
      ]),
      'founded' => new Optional([
        new Type('integer'),
      ]),
      'clubColors' => new Optional([
        new Type('string'),
      ]),
      'venue' => new Optional([
        new Type('string'),
      ]),
      'coach' => new Optional([
        new Type('array'),
        new Collection([
          'id' => new Required([
            new Type('integer'),
          ]),
          'name' => new Required([
            new Type('string'),
          ]),
          'dateOfBirth' => new Optional([
            new DateTime(['format' => 'Y-m-d']),
          ]),
          'nationality' => new Optional([
            new Type('string'),
          ]),
        ], NULL, NULL, TRUE),
      ]),
      'squad' => new Required([
        new Type('array'),
        new All([
          new Collection([
            'id' => new Required([
              new NotBlank(),
              new Type('integer'),
            ]),
            'name' => new Required([
              new NotBlank(),
              new Type('string'),
            ]),
            'position' => new Optional([
              new Type('string'),
            ]),
            'dateOfBirth' => new Optional([
              new DateTime(['format' => 'Y-m-d']),
            ]),
            'nationality' => new Optional([
              new Type('string'),
            ]),
          ], NULL, NULL, TRUE),
        ]),
      ]),
    ], NULL, NULL, TRUE);

    return $this->validator->validate($data, $constraint);
  }

  /**
   * Validate the data of a standing.
   *
   * @param array $data
   *   The data of a standing.
   *
   * @return \Symfony\Component\Validator\ConstraintViolationListInterface
   *   The list of constraint violations.
   */
  public function validateStanding(array $data): ConstraintViolationListInterface {
    $constraint = new Collection([
      'position' => new Required([
        new NotBlank(),
        new Type('integer'),
      ]),
      'team' => new Required([
        new Type('array'),
        new Collection([
          'id' => new Required([
            new NotBlank(),
            new Type('integer'),
          ]),
        ], NULL, NULL, TRUE),
      ]),
      'playedGames' => new Required([
        new Type('integer'),
      ]),
      'won' => new Required([
        new Type('integer'),
      ]),
      'draw' => new Required([
        new Type('integer'),
      ]),
      'lost' => new Required([
        new Type('integer'),
      ]),
      'points' => new Required([
        new Type('integer'),
      ]),
      'goalsFor' => new Required([
        new Type('integer'),
      ]),
      'goalsAgainst' => new Required([
        new Type('integer'),
      ]),
      'goalDifference' => new Required([
        new Type('integer'),
      ]),
    ], NULL, NULL, TRUE);

    return $this->validator->validate($data, $constraint);
  }
}
