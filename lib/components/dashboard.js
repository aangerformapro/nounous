

if (location.pathname.startsWith('/espace-utilisateur'))
{
    const
        toggler = document.querySelector('.navbar-toggler'),
        app = document.querySelector('.dashboard');
    toggler.addEventListener('click', e =>
    {

        e.preventDefault();
        app.classList.toggle('menu-shown');
    });
}
