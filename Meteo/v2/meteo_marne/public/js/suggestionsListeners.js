function suggestionsAddress(){
    const address = document.querySelector("input#address_addressSupplement.form-control")
    const suggestionsSupplement = document.querySelector("datalist#suggestionsSupplement")
    const suggestionsCity = document.querySelector("datalist#suggestionsCity")
    const postcode = document.querySelector("input#address_postalCode.form-control")
    address.addEventListener('input',()=>{
            suggestionsSupplement.innerHTML = '';
            suggestionsCity.innerHTML = '';
            if (address.value.length > 3 ){
                let url = `https://api-adresse.data.gouv.fr/search?q=${address.value}`;
                if (postcode.value !== ""){
                    url += `&postcode=${postcode.value}`
                }
                fetch(url)
                    .then(response =>{
                        return response.json();
                    })
                    .then((data) => {
                        let addressesSupplements = []
                        data.features.forEach((feature)=>{
                            if (!addressesSupplements.includes(feature.properties.name))
                            {
                                suggestionsSupplement.innerHTML += `<option value="${feature.properties.name}">`
                                addressesSupplements.push(feature.properties.name)
                            }
                            if (feature.properties.name === address.value ){
                                suggestionsCity.innerHTML += `<option value="${feature.properties.city}">`
                            }

                        })
                    }).catch(error => {
                    console.log('erreur')
                    console.error(`Erreur lors de la requête de récupération des données : ${error}`);
                });
            }
        }
    )
}

function suggestionsPostalCode(){
    const suggestionsCode = document.querySelector("datalist#suggestionsCode")
    const city = document.querySelector("input#address_city.form-control")
    city.addEventListener('input',()=>{
        if (city.value.length > 3 ){
            let url = `https://api-adresse.data.gouv.fr/search?q=${city.value}&type=municipality`;
            fetch(url)
                .then(response =>{
                    return response.json();
                })
                .then((data) => {
                    suggestionsCode.innerHTML = '';
                    let postCodes = []
                    data.features.forEach((city) => {
                        if (!postCodes.includes(city.properties.postcode))
                        {
                            suggestionsCode.innerHTML += `<option value="${city.properties.postcode}">`
                            postCodes.push(city.properties.postcode)
                        }
                    })

                }).catch(error => {
                console.log('erreur')
                console.error(`Erreur lors de la requête de récupération des données : ${error}`);
            });
        }
    })
}

function IsFormValid(){
    const address = document.querySelector("input#address_addressSupplement.form-control")
    const postcode = document.querySelector("input#address_postalCode.form-control")
    const city = document.querySelector("input#address_city.form-control")
    const form = document.querySelector("form")
    form.addEventListener('input',()=>{
        if (address.value.length > 3 ) {
            isAddressValid(address.value, city.value, postcode.value).then(result => {
                if (result){
                    setFiltersDisplay(true);
                }
                else{
                    setFiltersDisplay(false);
                }
            })

        }
    })
}