<?php
// Inclusion du modèle Users
require_once '../models/Users.php';
require_once '../models/Addresses.php';
require_once '../models/Countries.php';
require_once '../models/Localities.php';
$title = 'Mon compte';
$currentPage = 'my_account.php';
require '../views/head.php';
require '../views/navbar.php';

// Intialisation variable
/*$last_name_old ="";
$first_name_old ="";
$email_old="";
$address_id_old="";*/

// Vérification que l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: ../controllers/controller_login.php');
}

// Récupération de l'ID + role de l'utilisateur connecté
$user_id = $_SESSION['user_id'];
$role_id = $_SESSION['role_id'];

// Récupération données pour affichage value formulaire addresse
$user = new Users();
$user->getUserById($user_id);
$address_id = $user->getAddressId();

if(!isset($address_id)){
    $address = new Addresses();
    $address->createAddress("","","");
    $locality = new Localities();
    $locality->createLocality("","","");
}

if(isset($address_id)) {
    $addresses = new Addresses();
    $address = $addresses->getAddressById($address_id);

    $locality_id = $address->getLocalityId();
    $localities = new Localities();
    $locality = $localities->getLocalityById($locality_id);

    $country_id = $locality->getCountryId();
    $countries = new Countries();
    $country = $countries->getCountryById($country_id);
}

// Récupération des informations de l'utilisateur
try {
    $user = new Users();
    $user->getUserById($user_id);
    // Récupération des anciennes valeurs des champs de l'utilisateur
    $last_name_old = $user->getLastName();
    $first_name_old = $user->getFirstName();
    $password_old = $user->getPassword();
    $email_old = $user->getEmail();
    $address_id_old = $user->getAddressId();

    // Vérification que le formulaire a été soumis
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Récupération des données du formulaire
        $last_name = $_POST['last_name'];
        $first_name = $_POST['first_name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $password_confirm = $_POST['password_confirm'];
        //$address_id = $_POST['address'];

        // Vérification de la validité du mot de passe
        if (!empty($password) && $password !== $password_confirm) {
            $_SESSION["error_password"] = "Le mot de passe et sa confirmation ne correspondent pas";
        } else {
            // Mise à jour des informations de l'utilisateur
            $last_name = !empty($last_name) ? $last_name : $last_name_old;
            $first_name = !empty($first_name) ? $first_name : $first_name_old;
            if (empty($password) && empty($password_confirm)) {$password = $password_old;}
            $email = !empty($email) ? $email : $email_old;
            //$address_id = !empty($address_id) ? $address_id : $address_id_old;

            $user->updateUser($user_id, $last_name, $first_name, $password, $email, $address_id_old, $role_id);
            // Redirection vers la page de profil mise à jour
            header('Location: ../controllers/controller_my_account.php?message=success');
        }
    }
} catch (Exception $e) {
    // En cas d'erreur, afficher un message d'erreur
    $error = "Une erreur est survenue : " . $e->getMessage();
    $_SESSION["error_my_account"] = $error;
    //header("Location: controller_my_account.php");
}
// Inclusion de la vue "my_account"
require '../views/my_account.php';

