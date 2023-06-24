<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <h1>Résultats de la recherche</h1>

            <?php if ($users): ?>
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nom</th>
                        <th scope="col">Prénom</th>
                        <th scope="col">Email</th>
                        <th scope="col">Rôle</th>
                        <th scope="col">Actions</th>
                        <th scope="col">Statut</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <th scope="row"><?= $user->getUserId() ?></th>
                            <td><?= $user->getLastName() ?></td>
                            <td><?= $user->getFirstName() ?></td>
                            <td><?= $user->getEmail() ?></td>
                            <td><?= $user->roleLabel ?></td>
                            <td>
                                <a href="../controllers/controller_edit_user.php?id=<?= $user->getUserId() ?>" class="btn btn-primary">Modifier</a>
                            </td>
                            <td>
                                <?php if ($user->getActive() == 1): ?>
                                    <button class="btn btn-success btn-toggle" data-user-id="<?= $user->getUserId()?>" data-user-status="1">
                                        <i class="bi bi-check-circle-fill"></i> Actif
                                    </button>
                                <?php else: ?>
                                    <button class="btn btn-warning btn-toggle" data-user-id="<?= $user->getUserId() ?>" data-user-status="0">
                                        <i class="bi bi-x-circle-fill"></i> Inactif
                                    </button>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Aucun utilisateur trouvé.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

