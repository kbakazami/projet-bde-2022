<?php

namespace App\Repository;

use App\Entity\Role;
use PDO;

final class RoleRepository extends AbstractRepository
{

    protected const TABLE = 'role';

    public function save(Role $role): bool
    {
        $stmt = $this->pdo->prepare("INSERT INTO roles (name) VALUES (:name)");

        return $stmt->execute([
            'name' => $role->getName()
        ]);
    }

    public function findAllRole(){
        $stmt = $this->pdo->prepare("SELECT id, name FROM roles");

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function findRoleById(int $id){
        $stmt = $this->pdo->prepare("SELECT id, name FROM roles WHERE id = :id");

        $stmt->execute([
            'id' => $id
        ]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function updateRole(Role $role, $id){
        $stmt = $this->pdo->prepare("UPDATE roles SET name = :name WHERE id = :id");

        return $stmt->execute([
            'name' => $role->getName(),
            'id' => $id
        ]);
    }

    public function deleteRole(int $id){
        $stmt = $this->pdo->prepare("DELETE FROM roles WHERE id = :id");

        return $stmt->execute([
            'id' => $id
        ]);
    }
}
