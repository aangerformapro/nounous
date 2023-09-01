

document.querySelectorAll('form button.select-appointment').forEach(btn=>{


    const
        {form} = btn,
        area = form.querySelector('.form-select-child'),

        submit = form.querySelector('[type="submit"]');

    btn.addEventListener('click', e=>{
        e.preventDefault();
        btn.parentElement.classList.add('d-none');
        area.classList.remove('d-none');
    });
    form.querySelector('select')?.addEventListener('change', ({target})=>{

        if(target.value ?? null){
            submit.disabled = null;
        }

    });


});
