

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

        const [year, month, enfant] = [
            parseInt(formData.get('year')),
            parseInt(formData.get('month')),
            formData.get('enfant')
        ];




        let slug = '/' + year +'/' ;

        if(month<10){
            slug+='0';
        }
        slug+=month;


        if(enfant){
            slug+='/'+enfant;
        }


        location.href = action + slug;

    });

}


const printPDFBtn = document.getElementById('facture-pdf');

if(printPDFBtn){

    printPDFBtn.addEventListener('click' , e=>{
        e.preventDefault();
        $('body').scrollTop(0);
        createPDF();
    });

    let form = $('#facture'),
        cache_width= form.width(),
    a4=[595.28,841.89];

    function createPDF(){
        getCanvas().then(function(canvas){
            const
                img = canvas.toDataURL("image/png"),
                doc=new jsPDF({
                    unit:'px',
                    format:'a4'
                });
            doc.addImage(img,'JPEG',20,20);
            doc.save('DailySitterFacture.pdf');
            form.width(cache_width);
        });
    }
    function getCanvas(){
        form.width((a4[0]*1.33333)-80).css('max-width','none');
        return html2canvas(form,{
            imageTimeout: 2000,
            removeContainer: true
        });
    }
}

