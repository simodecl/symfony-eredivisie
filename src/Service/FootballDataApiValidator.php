<?php

namespace App\Service;

use Symfony\Component\Validator\Constraints\All;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Constraints\NotBlank;
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

    $constraint->allowExtraFields = true;

    return $this->validator->validate($data, $constraint);
  }
}
