document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM fully loaded, script is running.');

    const form = document.getElementById('inscriptionForm');
    if (!form) {
        console.error('Form with ID "inscriptionForm" not found.');
        return;
    }

    form.addEventListener('submit', function(event) {
        console.log('Form submission triggered.');

        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('mot_de_passe_confirm').value;
        const telephone = document.getElementById('telephone').value;

        // Supprimer les anciennes alertes
        const existingAlert = form.parentNode.querySelector('.alert-danger');
        if (existingAlert) {
            existingAlert.remove();
        }

        let hasError = false;

        if (password.length < 6) {
            console.log('Mot de passe trop court.');
            showError('Le mot de passe doit contenir au moins 6 caractères.');
            hasError = true;
        } else if (password !== confirmPassword) {
            console.log('Les mots de passe ne correspondent pas.');
            showError('Les mots de passe ne correspondent pas.');
            hasError = true;
        }

        if (!/^\d{8}$/.test(telephone)) {
            console.log('Numéro de téléphone invalide.');
            showError('Le numéro de téléphone doit contenir exactement 8 chiffres.');
            hasError = true;
        }

        if (hasError) {
            event.preventDefault();
        } else {
            console.log('Validation réussie, envoi du formulaire.');
        }

        function showError(message) {
            const alertDiv = document.createElement('div');
            alertDiv.className = 'alert alert-danger text-center';
            alertDiv.textContent = message;
            form.parentNode.insertBefore(alertDiv, form);
            setTimeout(() => alertDiv.remove(), 4000);
        }
    });

    const inscrireBtn = document.getElementById('inscrireBtn');
    const connecterBtn = document.getElementById('connecterBtn');

    if (inscrireBtn) {
        inscrireBtn.addEventListener('mouseover', function() {
            this.style.color = '#FFD1DC';
        });
        inscrireBtn.addEventListener('mouseout', function() {
            this.style.color = 'white';
        });
    } else {
        console.error('Button with ID "inscrireBtn" not found.');
    }

    if (connecterBtn) {
        connecterBtn.addEventListener('mouseover', function() {
            this.style.color = '#FFD1DC';
        });
        connecterBtn.addEventListener('mouseout', function() {
            this.style.color = '#6b2077';
        });
    } else {
        console.error('Button with ID "connecterBtn" not found.');
    }
});
