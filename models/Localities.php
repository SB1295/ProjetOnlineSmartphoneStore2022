<?php
require_once('Database.php');
require_once('Countries.php');

class Localities
{
    private $locality_id;
    private $city_name;
    private $postal_code;
    private $country_id;
    private $country;
    private $conn;

    public function __construct()
    {
        // Récupérer une instance de connexion PDO
        $this->conn = Database::getInstance();
    }

    // Getters
    public function getLocalityId()
    {
        return $this->locality_id;
    }

    public function getCityName()
    {
        return $this->city_name;
    }

    public function getPostalCode()
    {
        return $this->postal_code;
    }

    public function getCountryId()
    {
        return $this->country_id;
    }

    public function getCountry()
    {
        if (!$this->country) {
            $this->country = new Countries();
            $this->country->getCountryById($this->country_id);
        }
        return $this->country;
    }

    // Setters
    public function setLocalityId($locality_id)
    {
        $this->locality_id = $locality_id;
    }

    public function setCityName($city_name)
    {
        $this->city_name = $city_name;
    }

    public function setPostalCode($postal_code)
    {
        $this->postal_code = $postal_code;
    }

    public function setCountryId($country_id)
    {
        $this->country_id = $country_id;
    }

    public function createLocality($cityName, $postalCode, $countryId)
    {
        try {
            $this->conn->beginTransaction();

            $sql = "CALL createLocality(:cityName, :postalCode, :countryId, @localityId)";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':cityName', $cityName);
            $stmt->bindParam(':postalCode', $postalCode);
            $stmt->bindParam(':countryId', $countryId);

            if ($stmt->execute()) {

                // Récupérer l'ID de la localité créée
                $stmt = $this->conn->query("SELECT @localityId");
                $localityId = $stmt->fetch(PDO::FETCH_COLUMN);

                // Mise à jour des propriétés privées
                $this->locality_id = $localityId;
                $this->city_name = $cityName;
                $this->postal_code = $postalCode;
                $this->country_id = $countryId;

                // Validation de la transaction
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



    public function getLocalityById($localityId)
    {
        $sql = "CALL getLocalityById(:localityId)";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':localityId', $localityId);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetchObject('Localities');
            // Retourner l'objet Localities
            return $row;
        } else {
            // Gérer le cas où la localité n'est pas trouvée
            return false;
        }
    }

    public function updateLocality($localityId, $cityName, $postalCode, $countryId)
    {
        try {
            $this->conn->beginTransaction();

            $sql = "CALL updateLocality(:localityId, :cityName, :postalCode, :countryId)";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':localityId', $localityId);
            $stmt->bindParam(':cityName', $cityName);
            $stmt->bindParam(':postalCode', $postalCode);
            $stmt->bindParam(':countryId', $countryId);

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

    public function deleteLocality($localityId)
    {
        try {
            $this->conn->beginTransaction();

            $sql = "CALL deleteLocality(:localityId)";

            $stmt = $this->conn->prepare($sql);
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
}
