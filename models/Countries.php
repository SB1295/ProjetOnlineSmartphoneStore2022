<?php
require_once('Database.php');

class Countries
{
    private $country_id;
    private $country_name;
    private $iso;
    private $conn;

    public function __construct()
    {
        // Récupérer une instance de connexion PDO
        $this->conn = Database::getInstance();
    }

    // Getters
    public function getCountryId()
    {
        return $this->country_id;
    }

    public function getCountryName()
    {
        return $this->country_name;
    }

    public function getIso()
    {
        return $this->iso;
    }

    // Setters
    public function setCountryId($country_id)
    {
        $this->country_id = $country_id;
    }

    public function setCountryName($country_name)
    {
        $this->country_name = $country_name;
    }

    public function setIso($iso)
    {
        $this->iso = $iso;
    }

    public function createCountry($countryName, $iso)
    {
        try {
            // Début de la transaction
            $this->conn->beginTransaction();

            $sql = "CALL createCountry(:p_countryName, :p_iso, @countryId)";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':p_countryName', $countryName);
            $stmt->bindParam(':p_iso', $iso);

            $stmt->execute();

            // Récupérer l'ID du pays créé depuis la variable de sortie de la procédure stockée
            $countryIdStmt = $this->conn->query("SELECT @countryId");
            $countryId = $countryIdStmt->fetchColumn();

            // Mise à jour des propriétés privées
            $this->country_id = $countryId;
            $this->country_name = $countryName;
            $this->iso = $iso;

            // Validation de la transaction
            $this->conn->commit();

            return true;
        } catch (PDOException $e) {
            // En cas d'erreur, annulation de la transaction
            $this->conn->rollBack();

            // Gérer l'erreur ici
            return false;
        }
    }



    public function getCountryById($countryId)
    {
        $sql = "CALL getCountryById(:countryId)";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':countryId', $countryId);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetchObject('Countries');

            // Retourner l'objet Countries
            return $row;
        } else {
            // Gérer le cas où le pays n'est pas trouvé
            return false;
        }
    }

    public function updateCountry($countryId, $countryName, $iso)
    {
        try {
            // Début de la transaction
            $this->conn->beginTransaction();

            $sql = "CALL updateCountry(:countryId, :countryName, :iso)";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':countryId', $countryId);
            $stmt->bindParam(':countryName', $countryName);
            $stmt->bindParam(':iso', $iso);

            $stmt->execute();

            // Validation de la transaction
            $this->conn->commit();

            return true;
        } catch (PDOException $e) {
            // En cas d'erreur, annulation de la transaction
            $this->conn->rollBack();

            // Gérer l'erreur ici
            return false;
        }
    }

    public function deleteCountry($countryId)
    {
        try {
            // Début de la transaction
            $this->conn->beginTransaction();

            $sql = "CALL deleteCountry(:countryId)";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':countryId', $countryId);

            $stmt->execute();

            // Validation de la transaction
            $this->conn->commit();

            return true;
        } catch (PDOException $e) {
            // En cas d'erreur, annulation de la transaction
            $this->conn->rollBack();

            // Gérer l'erreur ici
            return false;
        }
    }

}
