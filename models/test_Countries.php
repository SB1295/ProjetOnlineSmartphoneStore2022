<?php
require_once 'Countries.php';

// Création de l'objet Countries
$countries = new Countries();

// Test de la méthode createCountry
$countryName = "Italie";
$iso = "ITA";
$result = $countries->createCountry($countryName, $iso);
echo "Test createCountry: " . ($result ? "Success" : "Failure") . "\n";

// Test de la méthode getCountryById
$countryId = $countries->getCountryId(); // Remplacer par l'ID du pays créé précédemment
var_dump($countryId);
$country = $countries->getCountryById($countryId);
echo "Test getCountryById:\n";
var_dump($country);


// Test de la méthode updateCountry
$countryId; // Remplacer par l'ID du pays à mettre à jour
$newCountryName = "United States";
$newIso = "US";
$result = $countries->updateCountry($countryId, $newCountryName, $newIso);
echo "Test updateCountry: " . ($result ? "Success" : "Failure") . "\n";

// Test de la méthode deleteCountry
$countryId; // Remplacer par l'ID du pays à supprimer
$result = $countries->deleteCountry($countryId);
echo "Test deleteCountry: " . ($result ? "Success" : "Failure") . "\n";



