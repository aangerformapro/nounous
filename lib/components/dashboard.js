

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



    addEventListener('click', e =>
    {

        let target = e.target.closest('button.edit');
        if (target)
        {

            e.preventDefault();

            let input = target.nextElementSibling;
            if (input)
            {
                input.disabled = null;
                target.form.querySelector('.form-submit-btn').classList.remove('d-none');
                target.remove();


            }



        }



    });


}
