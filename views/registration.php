<div class="container">
    <div class="row mt-4">
        <div class="col-md-12">
            <h1>Inscription</h1>
            <form id="registration-form" action="../controllers/controller_registration.php" method="post">
                <div class="form-group">
                    <label for="nom">Nom :</label>
                    <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Entrez votre nom" required>
                    <div class="invalid-feedback"></div>
                </div>
                <div class="form-group">
                    <label for="prenom">Prénom :</label>
                    <input type="text" class="form-control" id="firstName" name="firstName" placeholder="Entrez votre prénom" required>
                    <div class="invalid-feedback"></div>
                </div>
                <div class="form-group">
                    <label for="email">Adresse email :</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Entrez votre adresse email" required>
                    <div class="invalid-feedback"></div>
                </div>
                <div class="form-group">
                    <label for="password">Mot de passe :</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Entrez votre mot de passe" required>
                    <div class="invalid-feedback"></div>
                </div>
                <div class="form-group">
                    <label for="password_confirm">Confirmer le mot de passe :</label>
                    <input type="password" class="form-control" id="password_confirm" name="password_confirm" placeholder="Confirmez votre mot de passe" required>
                    <div class="invalid-feedback"></div>
                </div>
                <button type="submit" class="btn btn-primary" name="register">S'inscrire</button>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js"></script>
<script src="../views/scripts/validationRegistrationForm.js"></script>

</body>
</html>
