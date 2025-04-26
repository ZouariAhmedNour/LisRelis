// Mode sombre
document.addEventListener('DOMContentLoaded', () => {
    const toggleDarkModeBtn = document.createElement('button');
    toggleDarkModeBtn.textContent = 'Mode Sombre';
    toggleDarkModeBtn.className = 'btn btn-secondary mt-3';
    document.querySelector('.container').prepend(toggleDarkModeBtn);

    let isDarkMode = false;

    toggleDarkModeBtn.addEventListener('click', () => {
        isDarkMode = !isDarkMode;
        document.body.style.backgroundColor = isDarkMode ? '#2C1B2E' : '#F9F4F8';
        document.querySelectorAll('.card').forEach(card => {
            card.style.backgroundColor = isDarkMode ? '#3A2B3E' : '#FFFFFF';
        });
        document.querySelectorAll('.card-title, .card-text').forEach(text => {
            text.style.color = isDarkMode ? '#F9F4F8' : '#2C1B2E';
        });
        toggleDarkModeBtn.textContent = isDarkMode ? 'Mode Clair' : 'Mode Sombre';
    });

    // Recherche en temps réel
    const searchInput = document.querySelector('input[name="search"]');
    const resultsContainer = document.querySelector('.row');
    const livresPopulairesSection = document.querySelector('h2').nextElementSibling;

    searchInput.addEventListener('input', debounce((e) => {
        const query = e.target.value.trim();
        if (query.length < 2) {
            resultsContainer.innerHTML = livresPopulairesSection.innerHTML;
            document.querySelector('h2').textContent = 'Livres Populaires';
            return;
        }

        fetch(`${window.location.pathname}?search=${encodeURIComponent(query)}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            document.querySelector('h2').textContent = 'Résultats de la recherche';
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
                            <a href="#" class="btn btn-primary">Voir Plus</a>
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

    // Fonction pour éviter les appels trop fréquents lors de la frappe
    function debounce(func, wait) {
        let timeout;
        return function (...args) {
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(this, args), wait);
        };
    }
});