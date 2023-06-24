<?php
require_once('Permissions.php');

// Créer une nouvelle instance de la classe Permissions
$permissions = new Permissions();

// Créer une nouvelle permission
$permission_id = $permissions->createPermission('Permission 1', 'Description de la permission 1', 1);

// Vérifier que la permission a bien été créée
$permission = $permissions->getPermissionById($permission_id);
echo "Permission créée : ";
print_r($permission);

// Modifier la permission
$permissions->updatePermission($permission_id, 'Voici un nouvel update du titre', 'Nouvelle description', 0);

// Vérifier que la permission a bien été mise à jour
$permission = $permissions->getPermissionById($permission_id);
echo "Permission modifiée : ";
print_r($permission);

// Supprimer la permission
$permissions->deletePermission($permission_id);

// Vérifier que la permission a bien été supprimée
$permission = $permissions->getPermissionById($permission_id);
echo "Permission supprimée : ";
print_r($permission);

/*echo "Toutes les permissions :";
print_r($permissions->getAllPermissions());*/
?>

