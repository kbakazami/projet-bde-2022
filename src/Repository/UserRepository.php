<?php

namespace App\Repository;

use App\Entity\User;
use PDO;

final class UserRepository extends AbstractRepository
{
  protected const TABLE = 'users';

  public function save(User $user): bool
  {
    $stmt = $this->pdo->prepare("INSERT INTO users (firstname, lastname, mail, `password`, image, birthDate, id_role) VALUES (:firstname, :lastname, :mail, :password, :image, :birthDate, :id_role)");

    return $stmt->execute([
      'firstname' => $user->getFirstName(),
      'lastname' => $user->getlastName(),
      'mail' => $user->getEmail(),
      'password' => password_hash($user->getPassword(), PASSWORD_BCRYPT),
      'image' => $user->getImage(),
      'birthDate' => $user->getBirthDate()->format('Y-m-d'),
        'id_role' => $user->getIdRole()
    ]);
  }

  public function verifUser($mail){
      $stmt = $this->pdo->prepare("SELECT users.*, roles.title FROM users INNER JOIN roles ON users.id_role = roles.id WHERE mail=:mail");
      $stmt->bindValue("mail", $mail);
      $stmt->execute();
      return $stmt->fetch(PDO::FETCH_OBJ);
  }


  public function findByMail(string $mail)
  {
    $stmt = $this->pdo->prepare("SELECT mail FROM users WHERE mail=:mail");
    $stmt->execute(['mail' => $mail]);
    $result = $stmt->fetch();

    if($result){
        return true;
    }else{
        return false;
    }
  }

  public function findAllUser(){
      $stmt = $this->pdo->prepare("SELECT users.*, roles.title FROM `users` INNER JOIN roles ON users.id_role = roles.id");
      $stmt->execute();
      return $stmt->fetchAll(PDO::FETCH_OBJ);
  }

    public function findUserById(int $id){
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute([
            'id' => $id
        ]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function updateUser(User $user, $id){
        $stmt = $this->pdo->prepare("UPDATE users SET firstname = :firstname, lastname = :lastname, mail = :mail,  image = :image, birthDate = :birthDate, id_role = :id_role WHERE id = :id");

        return $stmt->execute([
            'firstname' => $user->getFirstName(),
            'lastname' => $user->getlastName(),
            'mail' => $user->getEmail(),
            'image' => $user->getImage(),
            'birthDate' => $user->getBirthDate()->format('Y-m-d'),
            'id_role' => $user->getIdRole(),
            'id' => $id
        ]);
    }

    public function deleteUser(int $id){
        $stmt = $this->pdo->prepare("DELETE FROM users WHERE id = :id");
        return $stmt->execute([
            'id' => $id
        ]);
    }
}
