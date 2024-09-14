// Récupérer l'élément de l'icone de l'oeil
const eyeIcon = document.querySelector('.password-toggle-icon');

// Ajouter un écouteur d'événements pour le clic sur l'icône de l'oeil
eyeIcon.addEventListener('click', togglePasswordVisibility);

// Fonction pour basculer entre le mode de masquage et d'affichage du mot de passe
function togglePasswordVisibility() {
    const passwordInput = document.getElementById('password');

    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        eyeIcon.innerHTML = '<i class="fas fa-eye-slash"></i>'; // Changer l'icône en œil barré
    } else {
        passwordInput.type = 'password';
        eyeIcon.innerHTML = '<i class="fas fa-eye"></i>'; // Changer l'icône en œilmmmmmm
    }
}

