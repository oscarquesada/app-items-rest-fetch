document.addEventListener('DOMContentLoaded', () => {
    const html = document.documentElement;
    const button = document.getElementById('themeToggle');

    const savedTheme = localStorage.getItem('theme') || 'light';
    html.setAttribute('data-theme', savedTheme);

    function updateButtonText() {
        button.textContent = html.getAttribute('data-theme') === 'dark'
            ? '☀️ Modo claro'
            : '🌙 Modo oscuro';
    }

    updateButtonText();

    button.addEventListener('click', () => {
        const currentTheme = html.getAttribute('data-theme');
        const newTheme = currentTheme === 'dark' ? 'light' : 'dark';

        html.setAttribute('data-theme', newTheme);
        localStorage.setItem('theme', newTheme);
        updateButtonText();
    });
});