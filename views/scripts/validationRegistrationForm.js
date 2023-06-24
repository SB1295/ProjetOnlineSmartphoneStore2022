// Récupérer les éléments du formulaire
const form = document.getElementById('registration-form');
const lastName = document.getElementById('lastName');
const firstName = document.getElementById('firstName');
const email = document.getElementById('email');
const password = document.getElementById('password');
const password_confirm = document.getElementById('password_confirm');

// Ajouter des écouteurs d'événements à chaque champ
lastName.addEventListener('input', validateLastName);
firstName.addEventListener('input', validateFirstName);
email.addEventListener('input', validateEmail);
password.addEventListener('input', validatePassword);
password_confirm.addEventListener('input', validatePasswordConfirm);

// Fonctions de validation pour chaque champ
function validateLastName() {
    if (lastName.value.trim() === '') {
        lastName.classList.add('is-invalid');
        lastName.nextElementSibling.textContent = "Le champ 'Nom' est obligatoire";
        return false;
    } else if (!/^[a-zA-Z\s]+$/.test(lastName.value)) {
        lastName.classList.add('is-invalid');
        lastName.nextElementSibling.textContent = "Le champ 'Nom' ne peut contenir que des lettres et des espaces";
        return false;
    } else {
        lastName.classList.remove('is-invalid');
        lastName.nextElementSibling.textContent = "";
        return true;
    }
}

function validateFirstName() {
    if (firstName.value.trim() === '') {
        firstName.classList.add('is-invalid');
        firstName.nextElementSibling.textContent = "Le champ 'Prénom' est obligatoire";
        return false;
    } else if (!/^[a-zA-Z\s]+$/.test(firstName.value)) {
        firstName.classList.add('is-invalid');
        firstName.nextElementSibling.textContent = "Le champ 'Prénom' ne peut contenir que des lettres et des espaces";
        return false;
    } else {
        firstName.classList.remove('is-invalid');
        firstName.nextElementSibling.textContent = "";
        return true;
    }
}

//
async function validateEmail() {
    if (!isValidEmail(email.value)) {
        email.classList.add('is-invalid');
        email.nextElementSibling.textContent = "Veuillez entrer une adresse email valide.";
        return false;
    } else {
        try {
            const exists = await userExists(email.value);
            if (exists) {
                email.classList.add('is-invalid');
                email.nextElementSibling.textContent = "Cette adresse email est déjà utilisée.";
                return false;
            } else {
                email.classList.remove('is-invalid');
                email.nextElementSibling.textContent = "";
                return true;
            }
        } catch (error) {
            console.log('Request failed: ' + error);
            return false;
        }
    }
}

function isValidEmail(email) {
    const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/i;
    return emailRegex.test(email);
}

async function userExists(email) {
    return new Promise((resolve, reject) => {
        fetch('../controllers/controller_email.php?action=userExists', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: 'email=' + encodeURIComponent(email)
        })
            .then(response => response.json())
            .then(data => {
                resolve(data.exists);
            })
            .catch(error => {
                reject(error);
            });
    });
}
//

function validatePassword() {
    if (!/(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*()\-_=+{};:,<.>§~|]).{8,}/.test(password.value)) {
        password.classList.add('is-invalid');
        password.nextElementSibling.textContent = "Le mot de passe doit contenir au moins 8 caractères, dont au moins une lettre minuscule, une lettre majuscule, un chiffre et un caractère spécial.";
        return false;
    } else {
        password.classList.remove('is-invalid');
        password.nextElementSibling.textContent = "";
        return true;
    }
}

function validatePasswordConfirm() {
    const passwordValue = password.value;
    const passwordConfirmValue = password_confirm.value;

    if (passwordValue !== passwordConfirmValue) {
        password_confirm.classList.add('is-invalid');
        password_confirm.nextElementSibling.textContent = "Les mots de passe ne correspondent pas.";
        return false;
    } else {
        password_confirm.classList.remove('is-invalid');
        password_confirm.nextElementSibling.textContent = "";
        return true;
    }
}

async function validateForm(event) {
    event.preventDefault();

    const isFirstNameValid = validateFirstName();
    const isLastNameValid = validateLastName();
    const isEmailValid = await validateEmail();
    const isPasswordValid = validatePassword();
    const isPasswordConfirmValid = validatePasswordConfirm();

    if (isFirstNameValid && isLastNameValid && isEmailValid && isPasswordValid && isPasswordConfirmValid) {
        //alert("Inscription réussie !");
        form.submit();
    }
}

form.addEventListener('submit', validateForm);

