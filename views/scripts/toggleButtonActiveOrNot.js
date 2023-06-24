document.addEventListener('DOMContentLoaded', function() {
    // Sélection des boutons à bascule
    const toggleButtons = document.querySelectorAll('.btn-toggle');

    // Gestionnaire d'événements de clic pour chaque bouton
    toggleButtons.forEach(button => {
        button.addEventListener('click', () => {
            // Récupérer l'ID de l'utilisateur et le statut à partir des attributs de données
            const userId = button.dataset.userId;
            const userStatus = button.dataset.userStatus;

            // Requête AJAX pour mettre à jour le statut de l'utilisateur
            const xhr = new XMLHttpRequest();
            xhr.open('POST', '../controllers/controller_update_user_status.php');
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                // Vérifier la réponse de la requête
                if (xhr.status === 200) {
                    // Mise à jour de l'apparence du bouton et du texte en fonction du nouveau statut
                    if (userStatus === '1') {
                        button.classList.remove('btn-success');
                        button.classList.add('btn-warning');
                        button.innerHTML = '<i class="bi bi-x-circle-fill"></i> Inactif';
                    } else {
                        button.classList.remove('btn-warning');
                        button.classList.add('btn-success');
                        button.innerHTML = '<i class="bi bi-check-circle-fill"></i> Actif';
                    }
                }
            };
            xhr.send(`userId=${userId}&userStatus=${userStatus}`);
        });
    });
});


