<?php
session_start();

// Supprime toutes les variables de session
$_SESSION = array();

// Détruit la session
session_destroy();

// Redirige l'utilisateur vers la page de connexion
header("location: ../controllers/controller_login.php");
exit;
?>
