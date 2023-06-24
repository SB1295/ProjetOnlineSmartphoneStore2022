<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <h1>Gestion des utilisateurs</h1>

            <form method="get" action="../controllers/controller_search_user.php">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Recherche...">
                    <button type="submit" class="btn btn-light">Rechercher</button>
                    <a href="../controllers/controller_add_user.php" class="btn btn-light">Ajouter</a>
                </div>
            </form>


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
                <?php if ($users): ?>
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
                <?php else: ?>
                    <tr>
                        <td colspan="6">Aucun utilisateur trouvé.</td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="../views/scripts/toggleButtonActiveOrNot.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js"></script>



</body>
</html>
