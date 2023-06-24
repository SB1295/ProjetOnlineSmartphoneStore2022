<?php
require_once '../models/Users.php';
$title = 'Connexion';
$currentPage = 'login.php';
require '../views/head.php';
require '../views/navbar.php';
require '../views/login.php';

// Si l'User est déjà login il est redirigé automatiquement vers la homepage
if (isset($_SESSION['user_id'])) {
   // header('Location: ../views/homepage.php');

}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les valeurs des champs du formulaire
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Vérifier que les champs ne sont pas vides et ont le bon format
    $errors = [];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "L'adresse email est invalide";
    }

    if (!preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*()\-_=+{};:,<.>§~|]).{8,}$/', $password)) {
        $errors[] = "Le mot de passe doit contenir au moins 8 caractères, dont au moins une lettre minuscule, une lettre majuscule, un chiffre et un caractère spécial.";
    }

    // S'il y a des erreurs, afficher un message d'erreur et rediriger l'utilisateur vers la page d'inscription
    if (!empty($errors)) {
        $_SESSION["errors"] = $errors;
        header("Location: ../views/login.php");
        exit();
    }

    // Connexion utilisateur
    try {
        $user = new Users();
        $isConnected = $user->getUserByLogin($email, $password);

        if ($isConnected) {
            $_SESSION["user_id"] = $user->getUserId(); // Stocker l'ID utilisateur dans la session
            $_SESSION["role_id"] = $user->getRoleId(); // Stocker l'ID du rôle de l'utilisateur dans la session
            $_SESSION["first_name"] = $user->getFirstName();
            header('Location: ../controllers/controller_homepage.php');

        } else {
            // Si l'utilisateur n'est pas connecté, afficher un message d'erreur
            $error = "Adresse email ou mot de passe incorrect";
            $_SESSION["login_wrong"] = $error;

            header('Location: ../controllers/controller_homepage.php');
        }
    } catch (Exception $e) {
        // Si une exception est générée, afficher un message d'erreur
        $error = "Une erreur est survenue : " . $e->getMessage();
        $_SESSION["login_error"] = $error;
        header('Location: ../controllers/controller_homepage.php');
    }

} else {
    // Si la requête n'est pas une requête POST, rediriger l'utilisateur vers la page de connexion
    //header("Location: ../views/login.php");
    exit();

}

