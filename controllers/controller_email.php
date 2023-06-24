<?php
require_once '../models/Users.php';

if (isset($_POST['email'])) {
    $email = $_POST['email'];

    function userExists($email) {
        // Vérifier si l'adresse email est valide
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // Vérifier si l'adresse email est déjà utilisée
            $user = new Users();
            $result = $user->userExists($email);
            // Je renvoie la réponse au format JSON pour que mon JS puisse le lire
            if ($result === false) {
                echo json_encode(array("exists" => false)); // L'adresse email est valide et n'est pas encore utilisée
            } else {
                echo json_encode(array("exists" => true)); // L'adresse email est déjà utilisée
            }
        } else {
            echo json_encode(array("error" => "invalid email")); // L'adresse email n'est pas valide
        }
    }
    // pour être appeler dans un autre fichier au cas où
    userExists($email);
}




