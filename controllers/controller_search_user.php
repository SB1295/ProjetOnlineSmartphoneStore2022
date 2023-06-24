<?php
// Inclure les fichiers nécessaires
require_once '../models/Users.php';
$title = 'Recherche';
$currentPage = 'search_result.php';
require '../views/head.php';
require '../views/navbar.php';

// Vérifier si la valeur de recherche est présente dans $_GET
if (isset($_GET['search'])) {
    // Récupérer la valeur de recherche
    $search = $_GET['search'];
    $user = new Users();

    // Vérifier si la valeur de recherche contient au moins 3 caractères
    if (strlen($search) >= 3) {
        // Effectuer la recherche des utilisateurs dans la base de données
        $users = $user->searchUser($search); // Remplacez par votre propre méthode de recherche

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

        // Charger la vue appropriée pour afficher les résultats de la recherche
        require '../views/search_result.php';
        exit();

        exit();
    }
}

// Si la condition de recherche n'est pas satisfaite ou si la valeur de recherche est vide,
// afficher tous les utilisateurs actifs par défaut
$users = $user->getActiveUsers(); // Remplacez par votre propre méthode pour récupérer les utilisateurs actifs

// Charger la vue appropriée pour afficher tous les utilisateurs actifs
require '../views/search_result.php';
