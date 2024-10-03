const darkModeToggle = document.getElementById('darkModeToggle');
const body = document.body;

// Verifica a preferência do usuário armazenada no localStorage
if (localStorage.getItem('darkMode') === 'enabled') {
    body.classList.add('dark-mode');
    darkModeToggle.textContent = 'Modo Claro';
}

// Adiciona o evento de clique para alternar o modo
darkModeToggle.addEventListener('click', () => {
    if (body.classList.contains('dark-mode')) {
        body.classList.remove('dark-mode');
        darkModeToggle.textContent = 'Modo Escuro';
        localStorage.setItem('darkMode', 'disabled');
    } else {
        body.classList.add('dark-mode');
        darkModeToggle.textContent = 'Modo Claro';
        localStorage.setItem('darkMode', 'enabled');
    }
});