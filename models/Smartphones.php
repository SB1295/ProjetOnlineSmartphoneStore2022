<?php

class Smartphones
{
    private $smartphone_id;
    private $smartphone_name;
    private $technical_sheet;
    private $price;
    private $link_picture;
    private $categorie_id;
    private $brand_id;
    private $conn;

    public function __construct()
    {
        // Récupérer une instance de connexion PDO
        $this->conn = Database::getInstance();
    }

    public function setSmartphoneId($smartphone_id)
    {
        $smartphone_id = intval($smartphone_id);
        if (!is_int($smartphone_id) || $smartphone_id < 1) {
            throw new \http\Exception\InvalidArgumentException("The permission ID must be a positive integer.");
        }
        $this->smartphone_id = $smartphone_id;
    }

    public function setSmartphoneName($smartphone_name)
    {
        if (!is_string($smartphone_name) || strlen($smartphone_name) > 300) {
            throw new InvalidArgumentException("The smartphone name must be a character string of maximum length 300.");
        }
        $this->smartphone_name = $smartphone_name;
    }


}