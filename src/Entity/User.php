<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Defines the properties of the User entity to represent the users.
 */
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface {
  #[ORM\Id]
  #[ORM\GeneratedValue]
  #[ORM\Column]
  private ?int $id = NULL;

  #[ORM\Column(length: 180)]
  private ?string $email = NULL;

  /**
   * The user roles.
   *
   * @var list<string>
   */
  #[ORM\Column]
  private array $roles = [];

  /**
   * The hashed password.
   *
   * @var string|null
   */
  #[ORM\Column]
  private ?string $password = NULL;

  #[ORM\Column(type: 'boolean')]
  private $isVerified = FALSE;

  /**
   * @var Collection<int, Team>
   */
  #[ORM\ManyToMany(targetEntity: Team::class)]
  private Collection $followedTeams;

  public function __construct()
  {
      $this->followedTeams = new ArrayCollection();
  }

  /**
   * Get the user ID.
   *
   * @return int|null
   *   The user ID.
   */
  public function getId(): ?int {
    return $this->id;
  }

  /**
   * Get the user email.
   *
   * @return string|null
   *   The user email.
   */
  public function getEmail(): ?string {
    return $this->email;
  }

  /**
   * Set the user email.
   *
   * @param string $email
   *   The user email.
   */
  public function setEmail(string $email): static {
    $this->email = $email;

    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getUserIdentifier(): string {
    return (string) $this->email;
  }

  /**
   * {@inheritdoc}
   */
  public function getRoles(): array {
    $roles = $this->roles;
    // Guarantee every user at least has ROLE_USER.
    $roles[] = 'ROLE_USER';

    return array_unique($roles);
  }

  /**
   * Set the user roles.
   *
   * @param array $roles
   *   The user roles.
   */
  public function setRoles(array $roles): static {
    $this->roles = $roles;

    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getPassword(): string {
    return $this->password;
  }

  /**
   * Set the user password.
   *
   * @param string $password
   *   The user password.
   */
  public function setPassword(string $password): static {
    $this->password = $password;

    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function eraseCredentials(): void {
    // If you store any temporary, sensitive data on the user, clear it here
    // $this->plainPassword = null;.
  }

  /**
   * Whether the user is verified.
   *
   * @return bool
   *   TRUE if the user is verified, FALSE otherwise.
   */
  public function isVerified(): bool {
    return $this->isVerified;
  }

  /**
   * Set whether the user is verified.
   *
   * @param bool $isVerified
   *   TRUE if the user is verified, FALSE otherwise.
   */
  public function setVerified(bool $isVerified): static {
    $this->isVerified = $isVerified;

    return $this;
  }

  /**
   * Get the followed teams.
   *
   * @return \App\Entity\Team[]
   *   The followed teams.
   */
  public function getFollowedTeams(): array {
      return $this->followedTeams->toArray();
  }

  /**
   * Add a followed team.
   *
   * @param Team $followedTeam
   *   The followed team.
   *
   * @return $this
   */
  public function addFollowedTeam(Team $followedTeam): static {
      if (!$this->followedTeams->contains($followedTeam)) {
          $this->followedTeams->add($followedTeam);
      }

      return $this;
  }

  /**
   * Remove a followed team.
   *
   * @param Team $followedTeam
   *   The followed team.
   *
   * @return $this
   */
  public function removeFollowedTeam(Team $followedTeam): static {
      $this->followedTeams->removeElement($followedTeam);

      return $this;
  }

}
