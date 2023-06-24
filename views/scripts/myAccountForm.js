// Récupération des éléments du formulaire
const form = document.getElementById('my-account-form');
const lastName = document.getElementById('last_name');
const firstName = document.getElementById('first_name');
const email = document.getElementById('email');
const password = document.getElementById('password');
const passwordConfirm = document.getElementById('password_confirm');
const address = document.getElementById('address');

// Ajout des écouteurs d'événements à chaque champ
lastName.addEventListener('input', validateLastName);
firstName.addEventListener('input', validateFirstName);
email.addEventListener('input', validateEmail);
password.addEventListener('input', validatePassword);
passwordConfirm.addEventListener('input', validatePasswordConfirm);

// Fonctions de validation pour chaque champ
function validateLastName() {
    const value = lastName.value.trim();

    if (value === '') {
        setInvalid(lastName, "Le champ 'Nom' est obligatoire.");
        return false;
    } else if (!/^[a-zA-Z\s]+$/.test(value)) {
        setInvalid(lastName, "Le champ 'Nom' ne peut contenir que des lettres et des espaces.");
        return false;
    } else {
        setValid(lastName);
        return true;
    }
}

function validateFirstName() {
    const value = firstName.value.trim();

    if (value === '') {
        setInvalid(firstName, "Le champ 'Prénom' est obligatoire.");
        return false;
    } else if (!/^[a-zA-Z\s]+$/.test(value)) {
        setInvalid(firstName, "Le champ 'Prénom' ne peut contenir que des lettres et des espaces.");
        return false;
    } else {
        setValid(firstName);
        return true;
    }
}

function validateEmail() {
    const value = email.value.trim();

    if (value === '') {
        setInvalid(email, "Le champ 'Email' est obligatoire.");
        return false;
    } else if (!isValidEmail(value)) {
        setInvalid(email, "Veuillez entrer une adresse email valide.");
        return false;
    } else {
        setValid(email);
        return true;
    }
}

function isValidEmail(email) {
    const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    return emailRegex.test(email);
}

function validatePassword() {
    const value = password.value.trim();

    if (value === '') {
        setValid(password);
        return true;
    }

    if (!/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*()\-_=+{};:,<.>§~|]).{8,}$/.test(value)) {
        setInvalid(password, "Le mot de passe doit contenir au moins 8 caractères, dont au moins une lettre minuscule, une lettre majuscule, un chiffre et un caractère spécial.");
        return false;
    } else {
        setValid(password);
        return true;
    }
}

function validatePasswordConfirm() {
    const passwordValue = password.value.trim();
    const passwordConfirmValue = passwordConfirm.value.trim();

    if (passwordValue === '' && passwordConfirmValue === '') {
        setValid(passwordConfirm);
        return true;
    }

    if (passwordValue !== passwordConfirmValue) {
        setInvalid(passwordConfirm, "Les mots de passe ne correspondent pas.");
        return false;
    } else {
        setValid(passwordConfirm);
        return true;
    }
}

function setInvalid(field, message) {
    field.classList.add('is-invalid');
    field.nextElementSibling.textContent = message;
}

function setValid(field) {
    field.classList.remove('is-invalid');
    field.nextElementSibling.textContent = '';
}

function validateForm(event) {
    event.preventDefault();

    const isFirstNameValid = validateFirstName();
    const isLastNameValid = validateLastName();
    const isEmailValid = validateEmail();
    const isPasswordValid = validatePassword();
    const isPasswordConfirmValid = validatePasswordConfirm();

    if (isFirstNameValid && isLastNameValid && isEmailValid && isPasswordValid && isPasswordConfirmValid) {
        form.submit();
    }
}

form.addEventListener('submit', validateForm);
