<?php
require_once '../models/Users.php';
require_once '../models/Addresses.php';
require_once '../models/Countries.php';
require_once '../models/Localities.php';

$title = 'Mon compte';
$currentPage = 'my_account.php';
require '../views/head.php';
require '../views/navbar.php';

// Vérification que l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: ../controllers/controller_login.php');
}

// Récupération données pour affichage value formulaire addresse
$user_id = $_SESSION['user_id'];
$user = new Users();
$user->getUserById($user_id);

$last_name = $user->getLastName();
$first_name = $user->getFirstName();
$password = $user->getPassword();
$email = $user->getEmail();
$address_id = $user->getAddressId();
$role_id = $user->getRoleId();
$active = $user->getActive();

if(!isset($address_id)) {
    $locality = new Localities();
    $locality->createLocality("", "", "");
    $address = new Addresses();
    $address->createAddress("", "", "");


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Récupération des données du formulaire
        $street_name = $_POST['street_name'];
        $number = $_POST['number'];
        $postal_code = $_POST['postal_code'];
        $city_name = $_POST['city_name'];
        $country_id = $_POST['country'];

        $locality = new Localities();
        $locality->createLocality($city_name,$postal_code,$country_id);
        $locality_id = $locality->getLocalityId();

        $address = new Addresses();
        $address->createAddress($street_name,$number,$locality_id);
        $address_id = $address->getAddressId();

        $user->updateUser($user_id,$last_name,$first_name,$password,$email,$address_id,$role_id,$active);
        header('Location: ../controllers/controller_my_account.php?message=success');
    }
}

if(isset($address_id)){
    $addresses = new Addresses();
    $address = $addresses->getAddressById($address_id);

    $locality_id = $address->getLocalityId();
    $localities = new Localities();
    $locality = $localities->getLocalityById($locality_id);

    $country_id = $locality->getCountryId();
    $countries = new Countries();
    $country = $countries->getCountryById($country_id);

    // Vérification que le formulaire a été soumis
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Récupération des données du formulaire
        $street_name = $_POST['street_name'];
        $number = $_POST['number'];
        $postal_code = $_POST['postal_code'];
        $city_name = $_POST['city_name'];
        $country_id = $_POST['country'];

        // Mise à jour de l'adresse et de la localité de l'utilisateur

        //$localities = new Localities();
        $locality->updateLocality($locality_id, $city_name,$postal_code,$country_id);
        //$address = new Addresses();
        $address->updateAddress($address_id,$street_name,$number,$locality_id);

        // Redirection vers la page de profil mise à jour
        header('Location: ../controllers/controller_my_account.php?message=success');
    }
}
require '../views/my_account.php';
