<?php
// Inclure le fichier contenant la classe "Users"
require_once('Users.php');

// Créer une instance de la classe "Users"
$users = new Users();

// Tester la méthode add()
//$userId = $users->addUser('James', 'Johnny', 'pAASssword1@==+', 'johnyatc@hotmail.be', 1,1);
//$userId = $users->addUser('Lawaree', 'Xavier', 'pAsswOr@d123456', 'lawaree_xavier@atc.be', null,1);
//$users->addUser('Benbelkacem', 'Sofian', 'sofianenPLS@d123456', 'bbk_sofian@atc.be', 1,1);
//$users->addUser("Wonka","Charlie","T0Pchocolat@d17777777","wonka_charlie@atc.be","2",);
//$users->addUser("Lablague","Toto","T0PchT@TO3lozpm3777","lablague_toto@atc.be","2",);
// Ici var_dump retourne true si le email et password correspondent
var_dump($users->getUserByLogin("charlieatc@hotmail.be","pAsswOr@d123456"));
//var_dump($userId);
echo "New user added with ID: " . $users->getUserId() . "\n";


// Tester la méthode getById()
if ($users->getUserById($users->getUserId())) {
    echo "User found with ID: " . $users->getUserId() . "\n";
    echo "Last name: " . $users->getLastName() . "\n";
    echo "First name: " . $users->getFirstName() . "\n";
    echo "Email: " . $users->getEmail() . "\n";
}

// Tester la méthode update()
//$users->updateUser($userId,'Bella    Amore  Delamatina','Jane     Julie    Gabriella','motdePassevraiment11===securi+@é','jane@atc.be',1,1);
echo "User updated with ID: " . $users->getUserId() . "\n";

// Tester la méthode getAll()
$allUsers = $users->getAllUsers();
echo "\nAll users:\n";
foreach ($allUsers as $user) {
    echo "ID: " . $user->getUserId() . "\n". "Last name: " . $user->getLastName() ."\n". "First name: " .$user->getFirstName(). "\n"."Email: " . $user->getEmail() . "\n";
}

// Tester la méthode delete()
//$users->deleteUser();
echo "\nUser deleted with ID: " . $users->getUserId() . "\n";
