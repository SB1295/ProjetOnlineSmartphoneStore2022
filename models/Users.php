<?php
require_once('Database.php');
class Users
{
    private $conn;
    private $userId;
    private $lastName;
    private $firstName;
    private $password;
    private $email;
    private $addressId;
    private $roleId;
    private $active;

    public function __construct()
    {
        // Récupérer une instance de connexion PDO
        $this->conn = Database::getInstance();
    }

    public function getUserById($userId)
    {
        // Vérification avec setter :
        $this->setUserId($userId);

        // $sql = "SELECT * FROM users WHERE user_id = ?";
        // Procédure stocké :
        $sql = "CALL getUserById(?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $this->userId, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            $this->userId = $result['user_id'];
            $this->lastName = $result['last_name'];
            $this->firstName = $result['first_name'];
            $this->password = $result['password'];
            $this->email = $result['email'];
            $this->addressId = $result['address_id'];
            $this->roleId = $result['role_id'];
            $this->active = $result['active'];
            return true;
        }
        return false;
    }

    public function getUserByLogin($email, $password)
    {
        $sql = "CALL getUserByLogin(:email)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() == 1) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $hashed_password = $row['password'];

            if (password_verify($password, $hashed_password)) {
                $this->userId = $row['user_id'];
                $this->lastName = $row['last_name'];
                $this->firstName = $row['first_name'];
                $this->email = $row['email'];
                $this->addressId = $row['address_id'];
                $this->roleId = $row['role_id'];
                $this->active = $row['active'];
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    // Setters
    public function setUserId(int $id): void
    {
        if ($id < 1) {
            throw new InvalidArgumentException('Invalid user ID.');
        }
        $this->userId = $id;
    }

    public function setLastName($lastName)
    {
        if (strlen($lastName) < 2 || strlen($lastName) > 255) {
            throw new Exception("Last name must be between 2 and 255 characters long");
        }
        if (!preg_match("/^[a-zA-Z\s]+$/", $lastName)) {
            throw new Exception("Last name can only contain letters and spaces");
        }
        // remplace les espaces consécutifs par un seul espace :
        $lastName = preg_replace('/\s+/', ' ', $lastName);
        $this->lastName = $lastName;
    }

    public function setFirstName($firstName)
    {
        if (strlen($firstName) < 2 || strlen($firstName) > 255) {
            throw new Exception("First name must be between 2 and 255 characters long");
        }
        if (!preg_match("/^[a-zA-Z\s]+$/", $firstName)) {
            throw new Exception("First name can only contain letters and spaces");
        }
        // remplace les espaces consécutifs par un seul espace :
        $firstName = preg_replace('/\s+/', ' ', $firstName);
        $this->firstName = $firstName;
    }

    public function setPassword(string $password): void
    {
        $length = strlen($password);
        if ($length < 8 || $length > 255 || empty($password)) {
            throw new InvalidArgumentException('Password must be between 8 and 255 characters.');
        }
        if (!preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*()\-_=+{};:,<.>§~|]).{8,}$/', $password)) {
            throw new InvalidArgumentException('Password must contain at least one digit, one lowercase character, one uppercase character, one special character and be at least 8 characters long.');
        }
        $this->password = $password;
    }

    public function setEmail(string $email): void
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || empty($email)) {
            throw new InvalidArgumentException('Invalid email address.');
        }
        $this->email = $email;
    }
    // Ajouter ? devant type de l'argument => permet à la méthode d'accepter une valeur nulle pour $addressId.
    public function setAddressId(?int $addressId): void
    {
        if ($addressId !== null && $addressId < 1) {
            throw new InvalidArgumentException('Invalid address ID.');
        }
        $this->addressId = $addressId;
    }

    public function setRoleId(int $roleId): void
    {
        if ($roleId < 1) {
            throw new InvalidArgumentException('Invalid role ID.');
        }
        $this->roleId = $roleId;
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
    public function getUserId()
    {
        if (isset($this->userId)) {
            return $this->userId;
        } else {
            throw new Exception("User ID not set");
        }
    }

    public function getLastName()
    {
        if (isset($this->lastName)) {
            return $this->lastName;
        } else {
            throw new Exception("Last name not set");
        }
    }

    public function getFirstName()
    {
        if (isset($this->firstName)) {
            return $this->firstName;
        } else {
            throw new Exception("First name not set");
        }
    }

    public function getPassword()
    {
        if (isset($this->password)) {
            return $this->password;
        } else {
            throw new Exception("Password not set");
        }
    }

    public function getEmail()
    {
        if (isset($this->email)) {
            return $this->email;
        } else {
            throw new Exception("Email not set");
        }
    }

    public function getAddressId()
    {
        if (isset($this->addressId)) {
            return $this->addressId;
        } else {
            return null; // return null si aucune adresse n'a été enregistré
        }
    }


    public function getRoleId()
    {
        if (isset($this->roleId)) {
            return $this->roleId;
        } else {
            throw new Exception("Role ID not set");
        }
    }

    public function getActive()
    {
        return $this->active;
    }

    public function userExists($email)
    {
        // Setters pour la vérification
        $this->setEmail($email);
        //$sql = "SELECT COUNT(*) FROM users WHERE username = :username OR email = :email";

        // Procédure stockée avec vérification à l'intérieur :
        $sql = "CALL userExists(:email, @userExists)";
        // Préparation de la requête SQL
        $stmt = $this->conn->prepare($sql);

        // Attribution des valeurs
        $stmt->bindValue(':email', $this->email);
        // Exécution de la requête
        $stmt->execute();

        // Récupération de la valeur de retour de la procédure stockée
        $selectSql = "SELECT @userExists AS userExists";
        $selectStmt = $this->conn->prepare($selectSql);
        $selectStmt->execute();

        $result = $selectStmt->fetch(PDO::FETCH_ASSOC);
        $userExists = $result['userExists'];
        $selectStmt->closeCursor();

        // Retourne vrai si l'utilisateur existe déjà, faux sinon
        if ($userExists == 1)
            return true;
        else
            return false;
    }

    public function addUser($lastName, $firstName, $password, $email, $addressId, $roleId = 2, $active = 1)
    {
        // Setters de vérifications
        $this->setLastName($lastName);
        $this->setFirstName($firstName);
        $this->setPassword($password);
        $this->setEmail($email);
        $this->setAddressId($addressId);
        $this->setRoleId($roleId);
        $this->setActive($active);

        /* le isset permet de savoir si la propriété $roleId de l'objet a été initialisée
        if (isset($roleId) && !empty($roleId)) {
            $this->setRoleId($roleId);
        } else {
            $this->setRoleId(2);
        } */

        // Vérification si l'utilisateur existe déjà dans la base de données
        if ($this->userExists($email)) {
            throw new Exception('User already exists');
        }

        // Hachage du mot de passe
        $options = [
            'cost' => 12,
        ];
        $hashedPassword = password_hash($this->password, PASSWORD_BCRYPT, $options);

        try {
            // Démarrage de la transaction
            $this->conn->beginTransaction();

            //$sql = "INSERT INTO users (username, password, email, address_id, role_id) VALUES (:username, :password, :email, :address_id, :role_id)";

            // Procédure stockée :
            $sql = "CALL addUser(:last_name, :first_name, :password, :email, :address_id, :role_id, :active, @user_id)";

            // Préparation de la requête SQL
            $stmt = $this->conn->prepare($sql);

            // Attribution des valeurs
            $stmt->bindValue(':last_name', $this->lastName);
            $stmt->bindValue(':first_name', $this->firstName);
            $stmt->bindValue(':password', $hashedPassword);
            $stmt->bindValue(':email', $this->email);
            $stmt->bindValue(':address_id', $this->addressId);
            $stmt->bindValue(':role_id', $this->roleId);
            $stmt->bindValue(':active', $this->active);

            // Exécution de la requête
            $stmt->execute();
            // Libère les résultats en attente
            $stmt->closeCursor();

            // Récupération de la valeur de retour de la procédure stockée
            $selectSql = "SELECT @user_id AS user_id";
            $selectStmt = $this->conn->prepare($selectSql);
            $selectStmt->execute();
            $result = $selectStmt->fetch(PDO::FETCH_ASSOC);
            $this->userId = $result['user_id'];

            // Validation de la transaction
            $this->conn->commit();
            return $this->userId;

        } catch (PDOException $e) {
            // Annulation de la transaction en cas d'erreur
            $this->conn->rollBack();
            throw new Exception("Error adding user: " . $e->getMessage());
        }
    }

    public function updateUser($userId, $lastName, $firstName, $password, $email, $addressId, $roleId, $active = 1)
    {
        // Setters de vérification :
        $this->setUserId($userId);
        $this->setLastName($lastName);
        $this->setFirstName($firstName);
        $this->setPassword($password);
        $this->setEmail($email);
        $this->setAddressId($addressId);
        $this->setRoleId($roleId);
        $this->setActive($active);

        // Hashage password en Bcrypt, coût 12, bon compris entre performance et sécurité :
        $options = [
            'cost' => 12,
        ];
        $hashedPassword = password_hash($this->password, PASSWORD_BCRYPT, $options);
        // Mise à jour des données dans la base de données
        try {
            // Début de la transaction
            $this->conn->beginTransaction();

            $sql = "CALL updateUser(:user_id, :last_name, :first_name, :password, :email, :address_id, :role_id, :active, @userUpdated)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':user_id', $this->userId, PDO::PARAM_INT);
            $stmt->bindValue(':last_name', $this->lastName, PDO::PARAM_STR);
            $stmt->bindValue(':first_name', $this->firstName, PDO::PARAM_STR);
            $stmt->bindValue(':password', $hashedPassword, PDO::PARAM_STR);
            $stmt->bindValue(':email', $this->email, PDO::PARAM_STR);
            $stmt->bindValue(':address_id', $this->addressId, PDO::PARAM_INT);
            $stmt->bindValue(':role_id', $this->roleId, PDO::PARAM_INT);
            $stmt->bindValue(':active', $this->active, PDO::PARAM_INT);
            $stmt->execute();

            // Récupération de la valeur de @userUpdated
            $selectSql = "SELECT @userUpdated AS userUpdated";
            $selectStmt = $this->conn->prepare($selectSql);
            $selectStmt->execute();

            $result = $selectStmt->fetch(PDO::FETCH_ASSOC);
            $userUpdated = $result['userUpdated'];
            $selectStmt->closeCursor();

            // Vérification de la valeur de @userUpdated
            if ($userUpdated == 1) {
                // Validation de la transaction
                $this->conn->commit();
                return true;
            } else {
                // Annulation de la transaction en cas d'erreur
                $this->conn->rollback();
                return false;
            }

            // Validation de la transaction
            $this->conn->commit();
        } catch (Exception $e) {
            // Annulation de la transaction en cas d'erreur
            $this->conn->rollback();
            throw new Exception("Error updating user: " . $e->getMessage());
        }
    }

    public function deleteUser()
    {
        // Construction de la requête SQL
        //$sql = "DELETE FROM users WHERE user_id = :user_id";

        // Exécution de la requête SQL en utilisant une transaction pour assurer l'intégrité de la base de données
        try {
            $this->conn->beginTransaction();
            $sql = "CALL deleteUser(:user_id)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':user_id', $this->userId, PDO::PARAM_INT);
            $stmt->execute();

            // Validation de la transaction
            $this->conn->commit();
        } catch (Exception $e) {
            // Annulation de la transaction en cas d'erreur
            $this->conn->rollback();
            throw new Exception("Error deleting user: " . $e->getMessage());
        }
    }

    public function getAllUsers()
    {
        // Construction de la requête SQL
        //$sql = "SELECT * FROM users";

        // Exécution de la requête SQL
        try {
            $sql = "CALL getAllUsers()";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();

            // Récupération des résultats de la requête SQL sous forme d'un tableau d'objets User
            $users = array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $user = new Users();
                $user->setUserId($row['user_id']);
                $user->setLastName($row['last_name']);
                $user->setFirstName($row['first_name']);
                $user->setEmail($row['email']);
                $user->setAddressId($row['address_id']);
                $user->setRoleId($row['role_id']);
                $user->setActive($row['active']);
                $users[] = $user;
            }

            return $users;
        } catch (Exception $e) {
            throw new Exception("Error retrieving users: " . $e->getMessage());
        }
    }

    public function searchUser($searchTerm)
    {
        $sql = "CALL searchUser(:search_term)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':search_term', $searchTerm, PDO::PARAM_STR);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $users = array();

        foreach ($results as $result) {
            $user = new Users();
            $user->setUserId($result['user_id']);
            $user->setLastName($result['last_name']);
            $user->setFirstName($result['first_name']);
            $user->setEmail($result['email']);
            $user->setAddressId($result['address_id']);
            $user->setRoleId($result['role_id']);
            $user->setActive($result['active']);

            // Ajoutez d'autres attributs si nécessaire

            $users[] = $user;
        }

        return $users;
    }


    public function getActiveUsers()
    {
        $sql = "CALL getActiveUsers()";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $users = array();

        foreach ($results as $result) {
            $user = array(
                'userId' => $result['user_id'],
                'lastName' => $result['last_name'],
                'firstName' => $result['first_name'],
                'email' => $result['email'],
                'addressId' => $result['address_id'],
                'roleId' => $result['role_id'],
                'active' => $result['active']
            );
            $users[] = $user;
        }
        return $users;
    }

    public function updateUserStatus($userId, $active)
    {
        $this->setUserId($userId);
        $this->setActive($active);

        try {
            $this->conn->beginTransaction();
            $sql = "CALL updateUserStatus(?, ?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(1, $this->active, PDO::PARAM_INT);
            $stmt->bindValue(2, $this->userId, PDO::PARAM_INT);

            $stmt->execute();

            $this->conn->commit();
        } catch (PDOException $e) {
            $this->conn->rollback();

        }
    }

}


