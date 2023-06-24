<?php
require_once '../models/Users.php';
$title = 'Inscription';
$currentPage = 'registration.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les valeurs des champs du formulaire
    $lastName = $_POST["lastName"];
    $firstName = $_POST["firstName"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $password_confirm = $_POST["password_confirm"];

    // Vérifier que les champs ne sont pas vides et ont le bon format
    $errors = [];

    if (empty($lastName)) {
        $errors[] = "Le champ 'Nom' est obligatoire";
    } elseif (!preg_match('/^[a-zA-Z\s]+$/', $lastName)) {
        $errors[] = "Le champ 'Nom' ne peut contenir que des lettres et des espaces";
    }

    if (empty($firstName)) {
        $errors[] = "Le champ 'Prénom' est obligatoire";
    } elseif (!preg_match('/^[a-zA-Z\s]+$/', $firstName)) {
        $errors[] = "Le champ 'Prénom' ne peut contenir que des lettres et des espaces";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "L'adresse email est invalide";
    }

    if (!preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*()\-_=+{};:,<.>§~|]).{8,}$/', $password)) {
        $errors[] = "Le mot de passe doit contenir au moins 8 caractères, dont au moins une lettre minuscule, une lettre majuscule, un chiffre et un caractère spécial.";
    }

    // Vérifier que les mots de passe correspondent
    if ($password !== $password_confirm) {
        $errors[] = "Les mots de passe ne correspondent pas.";
    }

    // S'il y a des erreurs, afficher le formulaire d'inscription avec les erreurs
    if (!empty($errors)) {
        require '../views/head.php';
        require '../views/navbar.php';
        require '../views/registration.php';
        exit();
    }

    // Enregistrer l'utilisateur dans la base de données
    try {
        // Ajouter l'utilisateur en base de données
        $user = new Users();
        $user->addUser($lastName, $firstName, $password, $email, null);

        // Redirection vers une page de confirmation
        header("Location: ../controllers/controller_accounts.php");
        exit();

    } catch (Exception $e) {
        // Gérer l'erreur ici
        $errorMessage = $e->getMessage();
        // Afficher le formulaire d'inscription avec l'erreur
        require '../views/head.php';
        require '../views/navbar.php';
        require '../views/registration.php';
        exit();
    }
} else {
    // Afficher le formulaire d'inscription par défaut
    require '../views/head.php';
    require '../views/navbar.php';
    require '../views/registration.php';
}
