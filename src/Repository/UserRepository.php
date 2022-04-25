<?php

namespace App\Repository;

use App\Entity\User;
use PDO;

final class UserRepository extends AbstractRepository
{
  protected const TABLE = 'users';

  public function save(User $user): bool
  {
    $stmt = $this->pdo->prepare("INSERT INTO users (firstname, lastname, mail, `password`, image, birthDate) VALUES (:firstname, :lastname, :mail, :password, :image, :birthDate)");

    return $stmt->execute([
      'firstname' => $user->getFirstName(),
      'lastname' => $user->getlastName(),
      'mail' => $user->getEmail(),
      'password' => password_hash($user->getPassword(), PASSWORD_BCRYPT),
      'image' => $user->getImage(),
      'birthDate' => $user->getBirthDate()->format('Y-m-d')
    ]);
  }

  public function getIdUser(User $user)
  {
    $stmt = $this->pdo->prepare("SELECT id FROM users");
    return $stmt->execute();
  }

  protected $table = "users";
  protected $class = User::class;

  public function findByMail(string $mail)
  {
    $stmt = $this->pdo->prepare("SELECT * FROM " . $this->table . " WHERE mail=:mail");

    $stmt->execute(['mail' => $mail]);
    $stmt->setFetchMode(PDO::FETCH_CLASS, $this->class);
    $result = $stmt->fetch();

    return ($result !== false) ? $result : [];
  }
}
