document.addEventListener('DOMContentLoaded', function () {
    console.log('Landing page script loaded! Welcome to Lis & Relis.');

    // Sélectionner les boutons
    const loginButton = document.querySelector('.landing-container .btn-primary');
    const registerButton = document.querySelector('.landing-container .btn-success');

    // Fonction pour ajouter un effet de "bounce"
    function addBounceEffect(element) {
        element.classList.add('bounce');
    }

    // Ajouter l'effet au clic sur les boutons
    if (loginButton) {
        loginButton.addEventListener('click', function (e) {
            addBounceEffect(loginButton);
        });
    }

    if (registerButton) {
        registerButton.addEventListener('click', function (e) {
            addBounceEffect(registerButton);
        });
    }
});

// Ajouter une classe CSS pour l'animation "bounce"
const style = document.createElement('style');
style.textContent = `
    .bounce {
        animation: bounceEffect 0.5s ease-in-out;
    }

    @keyframes bounceEffect {
        0% { transform: scale(1); }
        50% { transform: scale(1.1); }
        100% { transform: scale(1); }
    }
`;
document.head.appendChild(style);