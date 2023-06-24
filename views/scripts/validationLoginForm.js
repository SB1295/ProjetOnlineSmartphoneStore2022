// Récupérer les éléments du formulaire
const form = document.getElementById('login-form');
const email = document.getElementById('email');
const password = document.getElementById('password');
const invalidFeedback1 = document.getElementById('invalid-feedback1');
const invalidFeedback2 = document.getElementById('invalid-feedback2');

// Ajouter des écouteurs d'événements à chaque champ
email.addEventListener('input', validateEmail);
password.addEventListener('input', validatePassword);

function validateEmail() {
    const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/i;
    const testRegex = emailRegex.test(email.value)
    if (!testRegex) {
        email.classList.add('is-invalid');
        invalidFeedback1.textContent = "Veuillez entrer une adresse email valide.";
        return false;
    } else {
        email.classList.remove('is-invalid'); // Supprime la classe is-invalid si l'adresse email est valide
       invalidFeedback1.textContent = "";
        return true;
    }
}

function validatePassword() {
    if (!/(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*()\-_=+{};:,<.>§~|]).{8,}/.test(password.value)) {
        password.classList.add('is-invalid');
        invalidFeedback2.textContent = "Le mot de passe doit contenir au moins 8 caractères, dont au moins une lettre minuscule, une lettre majuscule, un chiffre et un caractère spécial.";
        return false;
    } else {
        password.classList.remove('is-invalid');
        invalidFeedback2.textContent = "";
        return true;
    }
}

// Modifier aussi cette fonction, je n'ai pas finis de travailler avec + tests
function validateForm(event) {
    event.preventDefault();

    const isEmailValid = validateEmail();
    const isPasswordValid = validatePassword();

    if (isEmailValid && isPasswordValid) {
        form.submit();
        }
    else {
        email.classList.add('is-invalid');
        password.classList.add('is-invalid');
        invalidFeedback1.textContent = "";
        invalidFeedback2.textContent = "L'adresse email ou le mot de passe sont invalides";
    }


}
form.addEventListener('submit', validateForm);
