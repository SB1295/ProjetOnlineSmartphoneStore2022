<?php
require_once '../models/Users.php';
$title = 'Modifier un utilisateur';
$currentPage = 'accounts.php';
require '../views/head.php';
require '../views/navbar.php';

// Vérification que l'utilisateur est un employé ou un administrateur
if ($_SESSION['role_id'] != 1 && $_SESSION['role_id'] != 3) {
    echo "Accès non autorisé.";
    exit();
}
if (isset($_GET['id'])) {
    $user_id = intval($_GET['id']);

    // Vérification supplémentaire pour les employés
    if ($_SESSION['role_id'] == 3) {
        $user = new Users();
        $user->getUserById($user_id);

        // Vérifier si l'utilisateur à modifier est un administrateur
        if ($user->getRoleId() == 1) {
            echo "Accès non autorisé.";
            exit();
        }
    }

    $user = new Users();
    $user->getUserById($user_id);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Récupérer les données du formulaire
        $id = $_POST['id'];
        $last_name = $_POST['last_name'];
        $first_name = $_POST['first_name'];
        $email = $_POST['email'];
        $role = $_POST['role'];
        $password = $_POST['password'];
        $password_confirmation = $_POST['password_confirmation'];
        $active = isset($_POST['active']) ? 1 : 0;

        // Valider les données et effectuer la mise à jour de l'utilisateur
        $errors = [];

        // Validation des champs (règles de validation ici)
        if (empty($last_name)) {
            $errors[] = "Le champ Nom est requis.";
        }

        if (empty($first_name)) {
            $errors[] = "Le champ Prénom est requis.";
        }

        if (empty($email)) {
            $errors[] = "Le champ Email est requis.";
        }

        // Vérifier si les mots de passe sont identiques (si l'utilisateur souhaite modifier le mot de passe)
        if (!empty($password) || !empty($password_confirmation)) {
            if ($password !== $password_confirmation) {
                $errors[] = "Les mots de passe ne correspondent pas.";
            }
        }

        // Si aucune erreur, mettre à jour l'utilisateur
        if (empty($errors)) {
            $user->setLastName($last_name);
            $user->setFirstName($first_name);
            $user->setEmail($email);
            $user->setRoleId($role);

            // Mettre à jour le mot de passe si fourni
            if (!empty($password)) {
                $user->setPassword($password);
            }

            // Appeler la méthode updateUser pour mettre à jour l'utilisateur
            $address_id = $user->getAddressId();
            $user->updateUser($id, $last_name, $first_name, $password, $email, $address_id, $role, $active);

            echo "L'utilisateur a été mis à jour avec succès.";
        } else {
            // Afficher les erreurs
            foreach ($errors as $error) {
                echo "<li>$error</li>";
            }
        }
    }

    require '../views/edit_user.php';
} else {
    echo "L'identifiant de l'utilisateur n'est pas spécifié.";
}
