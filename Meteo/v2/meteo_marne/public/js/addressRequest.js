function isAddressValid(address,city, postcode){
    return fetch(`https://api-adresse.data.gouv.fr/search?q=${address}&postcode=${postcode}`)
        .then(response => {return response.json()})
        .then((data)=>{
            let valid = false;
            if (data.hasOwnProperty("features")){
            data.features.forEach((cityRes)=>{
                if(city.toUpperCase() === cityRes.properties.city.toUpperCase() ) {
                    if (cityRes.properties.hasOwnProperty('postcode')){
                            if (String(cityRes.properties.postcode) === `${postcode}` ) {
                                valid = true;
                            }

                    }
                }
            })}
            return valid;
        }).catch(()=>{
            console.log('erreur')
        } )
}

function setFiltersDisplay(status) {
    document
        .querySelector("button.forbidden")
        .classList.toggle("hidden", !status);
    document
        .querySelector("div.forbidden")
        .classList.toggle("hidden", status);

}

function getCoordinateForCity(city,postalCode){
    return fetch(`https://geocoding-api.open-meteo.com/v1/search?name=${city}&type=municipality`)
        .then(response => response.json())
        .then((data)=>{
            let coordinates;
            data.results.forEach((cityRes)=>{

                if(cityRes.name.toUpperCase() === city.toUpperCase() ) {
                    if (cityRes.hasOwnProperty('postcodes')){
                        cityRes.postcodes.forEach((code)=>{
                            if (String(code) === postalCode ) {
                                coordinates = {latitude: cityRes.latitude, longitude: cityRes.longitude};
                            }
                        })

                    }

                }


            });
            return coordinates;
        })
}
