<?php
require_once('Database.php');
require_once ('Localities.php');

class Addresses
{
    private $address_id;
    private $street_name;
    private $number;
    private $locality_id;
    private $locality;
    private $conn;

    public function __construct()
    {
        // Récupérer une instance de connexion PDO
        $this->conn = Database::getInstance();
    }

    // Getters

    public function getAddressId()
    {
        return $this->address_id;
    }

    public function getStreetName()
    {
        return $this->street_name;
    }

    public function getNumber()
    {
        return $this->number;
    }

    public function getLocalityId()
    {
        return $this->locality_id;
    }

    public function getLocality()
    {
        if (!$this->locality) {
            $this->locality = new Localities();
            $this->locality->getLocalityById($this->locality_id);
        }
        return $this->locality;
    }

    // Setters

    public function setAddressId($address_id)
    {
        $this->address_id = $address_id;
    }

    public function setStreetName($street_name)
    {
        $this->street_name = $street_name;
    }

    public function setNumber($number)
    {
        $this->number = $number;
    }

    public function setLocalityId($locality_id)
    {
        $this->locality_id = $locality_id;
    }

    public function createAddress($streetName, $number, $localityId)
    {
        try {
            $this->conn->beginTransaction();

            $sql = "CALL createAddress(:streetName, :number, :localityId, @addressId)";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':streetName', $streetName);
            $stmt->bindParam(':number', $number);
            $stmt->bindParam(':localityId', $localityId);

            if ($stmt->execute()) {
                // Récupérer l'ID de l'adresse créée
                $addressIdStmt = $this->conn->query("SELECT @addressId");
                $addressId = $addressIdStmt->fetch(PDO::FETCH_COLUMN);

                // Mise à jour des propriétés privées
                $this->address_id = $addressId;
                $this->street_name = $streetName;
                $this->number = $number;
                $this->locality_id = $localityId;

                // Validation du la transaction
                $this->conn->commit();
                return true;
            } else {
                $this->conn->rollBack();
                // Gérer l'erreur ici
                return false;
            }
        } catch (PDOException $e) {
            $this->conn->rollBack();
            // Gérer l'erreur ici
            return false;
        }
    }


    public function getAddressById($addressId)
    {
        $sql = "CALL getAddressById(:addressId)";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':addressId', $addressId);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetchObject('Addresses');

            // Retourner l'objet Addresses
            return $row;
        } else {
            // Gérer le cas où l'adresse n'est pas trouvée
            return false;
        }
    }

    public function updateAddress($addressId, $streetName, $number, $localityId)
    {
        try {
            $this->conn->beginTransaction();

            $sql = "CALL updateAddress(:addressId, :streetName, :number, :localityId)";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':addressId', $addressId);
            $stmt->bindParam(':streetName', $streetName);
            $stmt->bindParam(':number', $number);
            $stmt->bindParam(':localityId', $localityId);

            if ($stmt->execute()) {
                $this->conn->commit();
                return true;
            } else {
                $this->conn->rollBack();
                // Gérer l'erreur ici
                return false;
            }
        } catch (PDOException $e) {
            $this->conn->rollBack();
            // Gérer l'erreur ici
            return false;
        }
    }

    public function deleteAddress($addressId)
    {
        try {
            $this->conn->beginTransaction();

            $sql = "CALL deleteAddress(:addressId)";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':addressId', $addressId);

            if ($stmt->execute()) {
                $this->conn->commit();
                return true;
            } else {
                $this->conn->rollBack();
                // Gérer l'erreur ici
                return false;
            }
        } catch (PDOException $e) {
            $this->conn->rollBack();
            // Gérer l'erreur ici
            return false;
        }
    }

}
