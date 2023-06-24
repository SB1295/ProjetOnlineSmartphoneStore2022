<?php
require_once 'Addresses.php';

// Création de l'objet Addresses
$addresses = new Addresses();

// Test de la méthode createAddress
$streetName = "Rue de la Paix";
$number = 10;
$localityId = 1; // Remplacer par l'ID de la localité associée
$result = $addresses->createAddress($streetName, $number, $localityId);
echo "Test createAddress: " . ($result ? "Success" : "Failure") . "\n";

// Test de la méthode getAddressById
$addressId = $addresses->getAddressId(); // Remplacer par l'ID de l'adresse créée précédemment
$address = $addresses->getAddressById($addressId);
echo "Test getAddressById:\n";
var_dump($address);

// Test de la méthode updateAddress
$addressId; // Remplacer par l'ID de l'adresse à mettre à jour
$newStreetName = "Main Street";
$newNumber = 20;
$newLocalityId = 2; // Remplacer par le nouvel ID de localité associée
$result = $addresses->updateAddress($addressId, $newStreetName, $newNumber, $newLocalityId);
echo "Test updateAddress: " . ($result ? "Success" : "Failure") . "\n";

// Test de la méthode deleteAddress
$addressId; // Remplacer par l'ID de l'adresse à supprimer
$result = $addresses->deleteAddress($addressId);
echo "Test deleteAddress: " . ($result ? "Success" : "Failure") . "\n";
