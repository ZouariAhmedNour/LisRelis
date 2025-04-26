document.addEventListener('DOMContentLoaded', () => {
    const currentTimeElement = document.getElementById('current-time');

    const updateTime = () => {
        const now = new Date();
        const timeString = now.toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
        currentTimeElement.textContent = timeString;
    };

    updateTime();
    setInterval(updateTime, 1000); // Mettre à jour toutes les secondes
});