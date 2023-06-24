<?php
require_once 'Localities.php';

// Création de l'objet Localities
$localities = new Localities();

// Test de la méthode createLocality
$cityName = "Charleroi";
$postalCode = 6000;
$countryId = 1; // Remplacer par l'ID du pays associé
$result = $localities->createLocality($cityName,$postalCode, $countryId);
echo "Test createLocality: " . ($result ? "Success" : "Failure") . "\n";

// Test de la méthode getLocalityById
$localityId = $localities->getLocalityId(); // Remplacer par l'ID de la localité créée précédemment
$locality = $localities->getLocalityById($localityId);
echo "Test getLocalityById:\n";
var_dump($locality);

// Test de la méthode updateLocality
$localityId; // Remplacer par l'ID de la localité à mettre à jour
$newCityName = "Bordeaux";
$newPostalCode = 30073;
$newCountryId = 2; // Remplacer par le nouvel ID de pays associé
$result = $localities->updateLocality($localityId, $newCityName,$newPostalCode, $newCountryId);
echo "Test updateLocality: " . ($result ? "Success" : "Failure") . "\n";


// Test de la méthode deleteLocality
$localityId; // Remplacer par l'ID de la localité à supprimer
$result = $localities->deleteLocality($localityId);
echo "Test deleteLocality: " . ($result ? "Success" : "Failure") . "\n";