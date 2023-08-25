

if (location.pathname.startsWith('/espace-utilisateur'))
{


    const
        toggler = document.querySelector('.navbar-toggler'),
        app = document.querySelector('.dashboard');


    toggler?.addEventListener('click', e =>
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

            let dataField = target.dataset.fields;

            if (dataField)
            {
                dataField = dataField.split(',').map(v => v.trim());

                dataField.forEach(sel => document.querySelectorAll(sel).forEach(elem => elem.disabled = null));
            }


            let input = target.nextElementSibling;
            if (input)
            {
                input.disabled = null;
                target.form.querySelector('.form-submit-btn')?.classList.remove('d-none');
                target.remove();
            }
        }

    });


    addEventListener('input', ({ target }) =>
    {


        const form = target.closest('form'), submitDiv = form?.querySelector('.form-submit-btn');
        if (form && submitDiv)
        {

            if (form.checkValidity())
            {
                submitDiv.classList.remove('d-none');
            }
            else
            {
                submitDiv.classList.add('d-none');
            }
        }


    });




    const addChildBtn = document.querySelector('#add-child-toggle'),
        addChildForm = document.querySelector('#add-child-form');


    addChildBtn?.addEventListener('click', e =>
    {
        e.preventDefault();
        addChildForm.classList.remove('d-none');
        addChildBtn.parentElement.classList.add("d-none");
    });

    addChildForm?.addEventListener("keyup", e =>
    {
        addChildForm.querySelector('.form-submit-btn').classList.remove('d-none');
    }, { once: true });

}
