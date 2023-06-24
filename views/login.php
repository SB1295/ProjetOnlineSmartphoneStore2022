<div class="container mt-4">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <h1>Connexion</h1>
            <form id="login-form" action="../controllers/controller_login.php" method="post">
                <div class="form-group">
                    <label for="email">Adresse email</label>
                    <input type="email" class="form-control" id="email" name ="email" placeholder="Entrez votre adresse email">
                    <div class="invalid-feedback" id="invalid-feedback1"></div>
                </div>
                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="password" name="password" placeholder="Entrez votre mot de passe">
                        <span class="input-group-text password-toggle-icon"><i class="fas fa-eye"></i></span>
                        <div class="invalid-feedback" id="invalid-feedback2"></div>
                    </div>
                </div>


                <?php
                if(isset($_SESSION["login_wrong"])){
                    echo "<div class='alert alert-danger'>".$_SESSION["login_wrong"]."</div>";
                    unset($_SESSION["login_wrong"]);
                }
                ?>

                <button type="submit" class="btn btn-primary" name="login">Se connecter</button>
            </form>
            <div class="mt-3">
                <a href="#">Mot de passe oublié ?</a>
                <span class="float-right">Pas encore inscrit ? <a href="registration.php">Créer un compte</a></span>
            </div>
        </div>
    </div>
</div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js"></script>
    <script src="../views/scripts/passwordToggle.js"></script>
<script src="../views/scripts/validationLoginForm.js"></script>



</body>
</html>
