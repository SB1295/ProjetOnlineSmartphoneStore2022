<?php
require_once('Database.php');
class Permissions
{
    private $permissionId;
    private $title;
    private $description;
    private $active;
    private $conn;

    public function __construct()
    {
        // Récupérer une instance de connexion PDO
        $this->conn = Database::getInstance();
    }

    // Setters
    public function setPermissionId($permissionId)
    {
        $permissionId =intval($permissionId);
        if (!is_int($permissionId) || $permissionId < 1) {
            throw new InvalidArgumentException("The permission ID must be a positive integer.");
        }
        $this->permissionId = $permissionId;
    }

    public function setTitle($title)
    {
        if (!is_string($title) || strlen($title) > 255) {
            throw new InvalidArgumentException("The title must be a character string of maximum length 255.");
        }
        $this->title = $title;
    }

    public function setDescription($description)
    {
        if (!is_string($description) || strlen($description) > 255) {
            throw new InvalidArgumentException("The description must be a string of maximum length 255.");
        }
        $this->description = $description;
    }

    public function setActive($active)
    {
        // Convertir la valeur en entier
        $active = intval($active);

        //Vérifier que la valeur est bien un nombre et qu'elle est soit 0 ou 1
        if (!is_numeric($active) || ($active !== 0 && $active !== 1)) {
            throw new Exception("Active must be either 0 or 1.");
        }
        $this->active = $active;
    }

    // Getters
    public function getPermissionId()
    {
        return $this->permissionId;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getActive()
    {
        return $this->active;
    }

    // Créer une permission
    public function createPermission($title, $description, $active)
    {
        $this->setTitle($title);
        $this->setDescription($description);
        $this->setActive($active);

        try {
            $this->conn->beginTransaction();
            //$sql = "INSERT INTO permissions (title, description, active) VALUES (:title, :description, :active)";
            $sql = "CALL createPermission(:title, :description, :active, @permission_id)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':title', $this->title);
            $stmt->bindParam(':description', $this->description);
            $stmt->bindParam(':active', $this->active);
            $stmt->execute();
            $stmt->closeCursor();

            $selectSql = "SELECT @permission_id AS permission_id";
            $selectStmt = $this->conn->prepare($selectSql);
            $selectStmt->execute();
            $result = $selectStmt->fetch(PDO::FETCH_ASSOC);
            $this->permissionId = $result['permission_id'];

            $this->conn->commit();
            return $this->permissionId;

        } catch (PDOException $e) {
            $this->conn->rollback();
            throw new Exception("Error when creating the permission : " . $e->getMessage());
        }
    }

    // Récupérer une permission par son ID
    public function getPermissionById($permission_id)
    {
        try {
            $this->setPermissionId($permission_id);
            $sql = "CALL getPermissionById(:permission_id, @title, @description, @active)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':permission_id', $this->permissionId);
            $stmt->execute();
            $stmt->closeCursor();

            $selectSql = "SELECT @title AS title, @description AS description, @active AS active";
            $selectStmt = $this->conn->prepare($selectSql);
            $selectStmt->execute();
            $permission = $selectStmt->fetch(PDO::FETCH_ASSOC);

            return $permission;
        } catch (PDOException $e) {
            throw new Exception("Error when retrieving permission : " . $e->getMessage());
        }
    }

    // Récupérer toutes les permissions
    public function getAllPermissions()
    {
        try {
            //$sql = "SELECT * FROM permissions";
            $sql = "CALL getAllPermissions()";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $permissions = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $permissions;
        } catch (PDOException $e) {
            throw new Exception("Error while retrieving permissions : " . $e->getMessage());
        }
    }

    // Mettre à jour une permission
    public function updatePermission($permission_id, $title, $description, $active)
    {
        try {
            $this->conn->beginTransaction();
            $this->setPermissionId($permission_id);
            $this->setTitle($title);
            $this->setDescription($description);
            $this->setActive($active);

            //$sql = "UPDATE permissions SET title = :title, description = :description, active = :active WHERE permission_id = :permission_id";
            $sql = "CALL updatePermission(:permission_id, :title, :description, :active)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':permission_id', $this->permissionId);
            $stmt->bindParam(':title', $this->title);
            $stmt->bindParam(':description', $this->description);
            $stmt->bindParam(':active', $this->active);
            $stmt->execute();
            $this->conn->commit();
            return true;
        } catch (PDOException $e) {
            $this->conn->rollback();
            throw new Exception("Error when updating the permission : " . $e->getMessage());
        }
    }

    public function deletePermission($permission_id)
    {
        $this->setPermissionId($permission_id);
        try {
            $this->conn->beginTransaction();
            //$sql = "DELETE FROM permissions WHERE permission_id = :permission_id";
            $sql = "CALL deletePermission(:permission_id)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':permission_id', $this->permissionId);
            $stmt->execute();
            $this->conn->commit();
            return true;

        } catch (PDOException $e) {
            $this->conn->rollBack();
            throw new Exception("Error when deleting permission : " . $e->getMessage());
        }
    }
}
