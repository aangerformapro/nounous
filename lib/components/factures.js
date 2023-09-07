

const factureSelectDate = document.getElementById('facture-select-date');

if(factureSelectDate instanceof HTMLElement){

    const
        currentYear = (new Date).getFullYear(),
        currentMonth = (new Date).getMonth() +1,
        submitArea = factureSelectDate.querySelector('.form-submit-btn'),
        action = factureSelectDate.getAttribute('action');

    factureSelectDate.addEventListener('change', e=>{

        e.preventDefault();
        const formData = new FormData(factureSelectDate);

        const [year, month] = [
            parseInt(formData.get('year')),
            parseInt(formData.get('month')),
        ];

        if(currentYear === year){

            submitArea.classList.add('d-none');
            if(month < currentMonth){
                submitArea.classList.remove('d-none');
            }
        }

    });


    factureSelectDate.addEventListener('submit', e=>{

        e.preventDefault();
        const formData = new FormData(factureSelectDate);

        const [year, month] = [
            parseInt(formData.get('year')),
            parseInt(formData.get('month')),
        ];

        let slug = '/' + year +'/' ;

        if(month<10){
            slug+='0';
        }
        slug+=month;
        location.href = action + slug;

    });

}