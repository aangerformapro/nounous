import VanillaAutoComplete from './vanilla-autocomplete.js';

function getZips(data)
{
    return [].concat(...data.map(i => i.codesPostaux)).filter((val, index, arr) => arr.indexOf(val) === index);
}



function renderCityItem(item)
{
    return item.nom + ' (' + item.codeDepartement + ')';
}

const routes = [
    '/register',
    '/espace-utilisateur',
];

if (routes.some(uri => location.pathname.startsWith(uri)))
{

    const
        zipInput = document.querySelector('input[name="zip"]'),
        cityInput = document.querySelector('input[name="city"]');

    if (zipInput && cityInput)
    {


        (() =>
        {


            let
                currentData = [],
                filteredData = [],
                lastZip = '',
                lastDept = '',
                fetching = false;


            new VanillaAutoComplete({
                selector: zipInput,
                minChars: 2,
                source(typed, fn)
                {

                    if (fetching || typed.length === 5)
                    {
                        return;
                    }

                    let dept = typed.slice(0, 2);
                    if (lastZip !== typed)
                    {
                        lastZip = typed;

                        if (lastDept !== dept)
                        {
                            lastDept = dept;
                            fetching = true;

                            fetch('https://geo.api.gouv.fr/communes?codeDepartement=' + dept)
                                .then(resp => resp.json())
                                .then(data =>
                                {

                                    fetching = false;
                                    currentData = data;


                                    fn(getZips(
                                        filteredData = currentData.filter(item =>
                                            item.codesPostaux.some(cp => cp.startsWith(typed))
                                        )
                                    ));
                                })
                                .catch(console.error);
                        }
                        else
                        {
                            fn(getZips(
                                filteredData = currentData.filter(item =>
                                    item.codesPostaux.some(cp => cp.startsWith(typed))
                                ))
                            );
                        }
                    }
                },
                onSelect: () =>
                {
                    cityInput.value = (filteredData[0]?.nom) ?? '';
                }
            });

        })();

        (() =>
        {


            let
                currentData = [],
                filteredData = [],
                lastTyped = '',
                resultMap = new Map(),
                fetching = false;

            const zipA = new VanillaAutoComplete({
                selector: cityInput,
                minChars: 3,
                source(typed, fn)
                {

                    if (fetching)
                    {
                        return;
                    }


                    if (lastTyped !== typed)
                    {
                        lastTyped = typed;


                        fetching = true;

                        fetch('https://geo.api.gouv.fr/communes?nom=' + typed)
                            .then(resp => resp.json())
                            .then(data =>
                            {

                                fetching = false;
                                currentData = data;
                                filteredData = currentData.filter(item =>
                                    item.nom.toLowerCase().startsWith(typed.toLowerCase())
                                );

                                resultMap.clear();


                                fn(filteredData.map(item =>
                                {

                                    let display = renderCityItem(item);
                                    resultMap.set(display, item);
                                    return display;
                                }));
                            })
                            .catch(console.error);

                    }
                },
                onSelect: (value) =>
                {
                    let zip;
                    if (zip = resultMap.get(value)?.codesPostaux[0])
                    {
                        zipInput.value = zip;
                        cityInput.value = resultMap.get(value).nom;
                    }

                }
            });

        })();
    }
}