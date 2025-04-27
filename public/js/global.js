document.addEventListener('DOMContentLoaded', () => {
    console.log("global.js chargé avec succès");

    const darkModePlaceholder = document.getElementById('dark-mode-placeholder');
    
    if (darkModePlaceholder) {
        console.log("Élément dark-mode-placeholder trouvé");
        const toggleDarkModeBtn = document.createElement('button');
        toggleDarkModeBtn.textContent = 'Mode Sombre';
        toggleDarkModeBtn.className = 'btn btn-secondary';
        darkModePlaceholder.appendChild(toggleDarkModeBtn);
        console.log("Bouton Mode Sombre ajouté");

        // Vérifier si le mode sombre est déjà activé (par exemple, en utilisant localStorage)
        let isDarkMode = localStorage.getItem('darkMode') === 'true';
        console.log("Mode sombre initial (de localStorage) :", isDarkMode);

        // Appliquer le mode sombre au chargement de la page
        if (isDarkMode) {
            document.body.classList.add('dark-mode');
            toggleDarkModeBtn.textContent = 'Mode Clair';
            // Forcer l'application des styles via JS
            applyDarkModeStyles(true);
            console.log("Mode sombre appliqué au chargement");
        }

        toggleDarkModeBtn.addEventListener('click', () => {
            isDarkMode = !isDarkMode;
            document.body.classList.toggle('dark-mode', isDarkMode);
            toggleDarkModeBtn.textContent = isDarkMode ? 'Mode Clair' : 'Mode Sombre';
            // Sauvegarder le choix de l'utilisateur dans localStorage
            localStorage.setItem('darkMode', isDarkMode);
            // Forcer l'application des styles via JS
            applyDarkModeStyles(isDarkMode);
            console.log("Mode sombre basculé :", isDarkMode);
        });
    } else {
        console.warn("Élément dark-mode-placeholder non trouvé dans le DOM");
    }

    // Fonction pour forcer l'application des styles du mode sombre
    function applyDarkModeStyles(isDarkMode) {
        if (isDarkMode) {
            document.body.style.backgroundColor = '#2C1B2E';
            document.body.style.color = '#F9F4F8';
            document.querySelectorAll('h1, h2, p, .card-text').forEach(el => {
                el.style.color = '#F9F4F8';
            });
            document.querySelectorAll('.btn-primary').forEach(btn => {
                btn.style.backgroundColor = '#A65482';
                btn.style.borderColor = '#A65482';
            });
            document.querySelectorAll('.btn-secondary').forEach(btn => {
                btn.style.backgroundColor = '#A65482';
                btn.style.borderColor = '#A65482';
                btn.style.color = '#F9F4F8';
            });
            if (document.querySelector('header')) {
                document.querySelector('header').style.backgroundColor = '#3A2B3E';
            }
            if (document.querySelector('footer')) {
                document.querySelector('footer').style.backgroundColor = '#1A0F1C';
            }
        } else {
            document.body.style.backgroundColor = '#F9F4F8';
            document.body.style.color = '#2C1B2E';
            document.querySelectorAll('h1, h2, p, .card-text').forEach(el => {
                el.style.color = '#2C1B2E';
            });
            document.querySelectorAll('.btn-primary').forEach(btn => {
                btn.style.backgroundColor = '#822C5D';
                btn.style.borderColor = '#822C5D';
            });
            document.querySelectorAll('.btn-secondary').forEach(btn => {
                btn.style.backgroundColor = '#C16AA3';
                btn.style.borderColor = '#C16AA3';
                btn.style.color = '#2C1B2E';
            });
            if (document.querySelector('header')) {
                document.querySelector('header').style.backgroundColor = '#F9F4F8';
            }
            if (document.querySelector('footer')) {
                document.querySelector('footer').style.backgroundColor = '#2C1B2E';
            }
        }
    }

    // Recherche en temps réel (spécifique à la page d'accueil)
    const searchInput = document.querySelector('input[name="search"]');
    const resultsContainer = document.querySelector('.search-results');
    const livresPopulairesSection = document.querySelector('.popular-books');

    if (searchInput && resultsContainer && livresPopulairesSection) {
        searchInput.addEventListener('input', debounce((e) => {
            const query = e.target.value.trim();
            if (query.length < 2) {
                resultsContainer.innerHTML = ''; // Effacer les résultats, mais ne pas afficher d'alerte
                return;
            }

            fetch(`${window.location.pathname}?search=${encodeURIComponent(query)}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                resultsContainer.innerHTML = '';
                if (data.length === 0) {
                    resultsContainer.innerHTML = '<p>Aucun livre trouvé.</p>';
                    return;
                }

                data.forEach(livre => {
                    const card = document.createElement('div');
                    card.className = 'col-md-4 mb-4';
                    card.innerHTML = `
                        <div class="card">
                            <img src="${livre.image}" class="card-img-top" alt="${livre.titre}">
                            <div class="card-body">
                                <h5 class="card-title">${livre.titre}</h5>
                                <p class="card-text">Auteur : ${livre.auteur}</p>
                                <p class="card-text">Genre : ${livre.genre}</p>
                                <a href="${window.location.origin}/lisrelis/public/detailsLivre/${livre.id}" class="btn btn-primary">Voir Plus</a>
                            </div>
                        </div>
                    `;
                    resultsContainer.appendChild(card);
                });
            })
            .catch(error => {
                console.error('Erreur lors de la recherche:', error);
                resultsContainer.innerHTML = '<p>Une erreur est survenue lors de la recherche.</p>';
            });
        }, 300));
    }

    // Gestion du formulaire de recherche pour la page "Gestion des Livres"
    const searchForm = document.querySelector('form[action*="livres"]');
    if (searchForm) {
        searchForm.addEventListener('submit', (e) => {
            const searchInput = searchForm.querySelector('input[name="search"]');
            const query = searchInput.value.trim();
            if (query === '') {
                // Ne pas empêcher la soumission, laisser le serveur gérer (affichera tous les livres)
                return;
            }
        });
    }

    // Fonction pour éviter les appels trop fréquents lors de la frappe
    function debounce(func, wait) {
        let timeout;
        return function (...args) {
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(this, args), wait);
        };
    }

    // Dynamique du header (message de bienvenue)
    const welcomeText = document.getElementById('welcome-text');
    
    const updateWelcomeMessage = () => {
        const hour = new Date().getHours();
        let message = '';

        if (hour >= 5 && hour < 12) {
            message = 'Bon matin !';
        } else if (hour >= 12 && hour < 18) {
            message = 'Bon après-midi !';
        } else {
            message = 'Bonsoir !';
        }

        if (welcomeText) {
            welcomeText.textContent = message;
        }
    };

    if (welcomeText) {
        updateWelcomeMessage();
    }

    // Dynamique du footer (heure actuelle)
    const currentTimeElement = document.getElementById('current-time');

    const updateTime = () => {
        const now = new Date();
        const timeString = now.toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
        if (currentTimeElement) {
            currentTimeElement.textContent = timeString;
        }
    };

    if (currentTimeElement) {
        updateTime();
        setInterval(updateTime, 1000); // Mettre à jour toutes les secondes
    } else {
        console.warn("L'élément avec l'ID 'current-time' n'a pas été trouvé dans le DOM.");
    }
});