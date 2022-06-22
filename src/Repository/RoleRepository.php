<?php

namespace App\Repository;

use App\Entity\Role;
use PDO;

final class RoleRepository extends AbstractRepository
{

    protected const TABLE = 'role';

    public function save(Role $role): bool
    {
        $stmt = $this->pdo->prepare("INSERT INTO roles (title) VALUES (:title)");

        return $stmt->execute([
            'title' => $role->getTitle()
        ]);
    }

    public function findAllRole(){
        $stmt = $this->pdo->prepare("SELECT id, title FROM roles");

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function findRoleById(int $id){
        $stmt = $this->pdo->prepare("SELECT id, title FROM roles WHERE id = :id");

        $stmt->execute([
            'id' => $id
        ]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function updateRole(Role $role, $id){
        $stmt = $this->pdo->prepare("UPDATE roles SET title = :title WHERE id = :id");

        return $stmt->execute([
            'title' => $role->getTitle(),
            'id' => $id
        ]);
    }

    public function deleteRole(int $id){
        $stmt = $this->pdo->prepare("DELETE FROM roles WHERE id = :id");

        return $stmt->execute([
            'id' => $id
        ]);
    }

    public function setDefaultRole(int $id){
        $stmt = $this->pdo->prepare("UPDATE users SET id_role = 10 WHERE id_role = :id");

        return $stmt->execute([
            'id' => $id
        ]);
    }
}
