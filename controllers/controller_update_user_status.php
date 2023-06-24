<?php
// Inclure les fichiers nécessaires
require_once '../models/Users.php';

if (isset($_POST['userId']) && isset($_POST['active'])) {

    $userId = $_POST['userId'];
    $active = $_POST['active'];

    $user = new Users();
    $user->updateUserStatus($userId, $active);

    // Envoyer une réponse réussie
    http_response_code(200);
} else {
    // Envoyer une réponse d'erreur
    http_response_code(400);
}
