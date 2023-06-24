<?php
require_once '../models/Users.php';
$title = 'Utilisateurs';
$currentPage = 'accounts.php';

// Vérifier si l'utilisateur est connecté et a un rôle d'administrateur
require '../views/head.php';

// Vérifier si la valeur de recherche est présente dans $_GET
if (isset($_GET['search'])) {
    // Rediriger vers le contrôleur de recherche d'utilisateurs
    header('Location: ../controllers/controller_search_user.php?search=' . $_GET['search']);
    exit();
}

// Vérifier si l'utilisateur est connecté et a un rôle d'administrateur
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role_id']) || $_SESSION['role_id'] != 1 && $_SESSION['role_id'] != 3) {
    header('Location: ../controllers/controller_homepage.php');
}

// Récupérer la liste des utilisateurs
try {
    $user = new Users();
    $users = $user->getAllUsers();

    // Modifier les rôles en libellés correspondants
    foreach ($users as $user) {
        $roleLabel = '';

        switch ($user->getRoleId()) {
            case 1:
                $roleLabel = 'Administrateur';
                break;
            case 2:
                $roleLabel = 'Utilisateur';
                break;
            case 3:
                $roleLabel = 'Employé';
                break;
            // Ajoutez d'autres cas si nécessaire

            default:
                $roleLabel = 'Inconnu';
                break;
        }

        // Enregistrement du libellé du rôle dans l'objet utilisateur
        $user->roleLabel = $roleLabel;
    }
} catch (Exception $e) {
    // En cas d'erreur, afficher un message d'erreur
    $error = "Une erreur est survenue : " . $e->getMessage();
    $_SESSION["error_accounts"] = $error;
    header("Location: error.php");
}

require '../views/navbar.php';
require '../views/accounts.php';
