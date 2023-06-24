<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="../index.php">Smartphone Store</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <?php if (isset($_SESSION['user_id'])) { ?>
            <ul class="navbar-nav mr-auto">
                <li class="nav-item <?php if ($currentPage === 'homepage.php') echo 'active'; ?>">
                    <a class="nav-link" href="../controllers/controller_homepage.php">Accueil</a>
                </li>
                <li class="nav-item <?php if ($currentPage === 'products.php') echo 'active'; ?>">
                    <a class="nav-link" href="../controllers/controller_products.php">Produits</a>
                </li>
                <li class="nav-item <?php if ($currentPage === 'contact.php') echo 'active'; ?>">
                    <a class="nav-link" href="../controllers/controller_contact.php">Contact</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <span class="nav-link">Bonjour, <?php echo $_SESSION['first_name']; ?>!</span>
                </li>
                <li class="nav-item <?php if ($currentPage === 'cart.php') echo 'active'; ?>">
                    <a class="nav-link" href="../controllers/controller_cart.php">Panier</a>
                </li>
                <li class="nav-item <?php if ($currentPage === 'my_account.php') echo 'active'; ?>">
                    <a class="nav-link" href="../controllers/controller_my_account.php">Mon compte</a>
                </li>
                <?php if ($_SESSION['role_id'] == 1 || $_SESSION['role_id'] == 3) { ?>
                    <li class="nav-item <?php if ($currentPage === 'accounts.php') echo 'active'; ?>">
                        <a class="nav-link" href="../controllers/controller_accounts.php">Utilisateurs</a>
                    </li>
                <?php } ?>
                <li class="nav-item">
                    <a class="nav-link" href="../views/logout.php">Déconnexion</a>
                </li>
            </ul>
        <?php } else { ?>
            <ul class="navbar-nav mr-auto">
                <li class="nav-item <?php if ($currentPage === 'homepage.php') echo 'active'; ?>">
                    <a class="nav-link" href="../controllers/controller_homepage.php">Accueil</a>
                </li>
                <li class="nav-item <?php if ($currentPage === 'products.php') echo 'active'; ?>">
                    <a class="nav-link" href="../controllers/controller_products.php">Produits</a>
                </li>
                <li class="nav-item <?php if ($currentPage === 'contact.php') echo 'active'; ?>">
                    <a class="nav-link" href="../controllers/controller_contact.php">Contact</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="../controllers/controller_login.php">Connexion</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../controllers/controller_registration.php">Inscription</a>
                </li>
            </ul>
        <?php } ?>
    </div>
</nav>
