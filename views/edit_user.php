<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <h1>Modifier un utilisateur</h1>
            <?php if (isset($errors) && count($errors) > 0): ?>
                <div class="alert alert-danger">
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li><?= $error ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
            <form id="edit-user-form" action="../controllers/controller_edit_user.php" method="POST">
                <input type="hidden" name="id" id="id" value="<?= $user->getUserId() ?>">

                <div class="form-group row">
                    <div class="col-md-6">
                        <label for="last_name">Nom</label>
                        <input type="text" name="last_name" id="last_name" class="form-control" value="<?= $user->getLastName() ?>">
                    </div>
                    <div class="col-md-6">
                        <label for="first_name">Prénom</label>
                        <input type="text" name="first_name" id="first_name" class="form-control" value="<?= $user->getFirstName() ?>">
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-6">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control" value="<?= $user->getEmail() ?>">
                    </div>
                    <div class="col-md-6">
                        <label for="role">Rôle</label>
                        <select name="role" id="role" class="form-control">
                            <option value="1" <?= $user->getRoleId() == 1 ? 'selected' : '' ?>>Admin</option>
                            <option value="2" <?= $user->getRoleId() == 2 ? 'selected' : '' ?>>Utilisateur</option>
                            <option value="3" <?= $user->getRoleId() == 3 ? 'selected' : '' ?>>Employé</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">Nouveau mot de passe (laissez vide pour ne pas changer)</label>
                    <input type="password" name="password" id="password" class="form-control">
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirmer le nouveau mot de passe</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                </div>

                <div class="form-group">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="active" id="active" value="1" <?= $user->getActive() ? 'checked' : '' ?>>
                        <label class="form-check-label" for="active">
                            Activer l'utilisateur
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Valider</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js"></script>



</body>
</html>
