<div class="container mt-4">
    <?php if (isset($_GET['message']) && $_GET['message'] === 'success'): ?>
        <div class="alert alert-success" role="alert">
            Vos informations ont été mises à jour avec succès.
        </div>
    <?php endif; ?>

    <h2>Mon compte</h2>
    <form id="my-account-form" method="POST" action ="../controllers/controller_my_account.php">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="last_name">Nom</label>
                <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo htmlspecialchars($user->getLastName()); ?>">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group col-md-6">
                <label for="first_name">Prénom</label>
                <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo htmlspecialchars($user->getFirstName()); ?>">
                <div class="invalid-feedback"></div>
            </div>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user->getEmail()); ?>">
            <div class="invalid-feedback"></div>
        </div>
        <div class="form-group">
            <label for="password">Mot de passe</label>
            <input type="password" class="form-control" id="password" name="password">
            <div class="invalid-feedback"></div>
        </div>
        <div class="form-group">
            <label for="password_confirm">Confirmation du mot de passe</label>
            <input type="password" class="form-control" id="password_confirm" name="password_confirm">
            <div class="invalid-feedback"></div>
        </div>
        <button type="submit" class="btn btn-primary">Mettre à jour</button>
    </form>

    <div class="mt-4"></div>

    <h2>Adresse</h2>
    <form id="my-account-form-address" method="POST" action="../controllers/controller_my_account_address.php">
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="street_name">Nom de la rue</label>
                    <input type="text" class="form-control" id="street_name" name="street_name" value="<?php echo $address->getStreetName() ? htmlspecialchars($address->getStreetName()) : ''; ?>">
                    <div class="invalid-feedback"></div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    <label for="street_number">Numéro</label>
                    <input type="text" class="form-control" id="number" name="number" value="<?php echo $address->getNumber() ? htmlspecialchars($address->getNumber()) : ''; ?>">
                    <div class="invalid-feedback"></div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    <label for="postal_code">Code postal</label>
                    <input type="text" class="form-control" id="postal_code" name="postal_code"
                           value="<?php echo $locality->getPostalCode() ?htmlspecialchars($locality->getPostalCode()) : ''; ?>">
                    <div class="invalid-feedback"></div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="city">Ville</label>
                    <input type="text" class="form-control" id="city_name" name="city_name" value="<?php echo $locality->getCityName() ? htmlspecialchars($locality->getCityName()) : ''; ?>">
                    <div class="invalid-feedback"></div>
                </div>
            </div>
            <div class="col-sm-6">
                <!-- Champ pour le pays -->
                <div class="form-group">
                    <label for="country">Pays</label>
                    <select name="country" id="country" class="form-control">
                        <option value="1" <?php if ($locality->getCountryId() == 1) echo 'selected'; ?>>Belgique</option>
                        <option value="2" <?php if ($locality->getCountryId() == 2) echo 'selected'; ?>>France</option>
                        <option value="3" <?php if ($locality->getCountryId() == 3) echo 'selected'; ?>>Luxembourg</option>
                        <option value="4" <?php if ($locality->getCountryId() == 4) echo 'selected'; ?>>Allemagne</option>
                        <option value="5" <?php if ($locality->getCountryId() == 5) echo 'selected'; ?>>Italie</option>
                        <option value="6" <?php if ($locality->getCountryId() == 6) echo 'selected'; ?>>Suisse</option>
                        <option value="7" <?php if ($locality->getCountryId() == 7) echo 'selected'; ?>>Royaume-Uni</option>
                    </select>
                </div>

            </div>
        </div>
        <button type="submit" class="btn btn-primary">Mettre à jour</button>
    </form>

</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js"></script>
<script src="../views/scripts/myAccountForm.js"></script>


</body>

</html>