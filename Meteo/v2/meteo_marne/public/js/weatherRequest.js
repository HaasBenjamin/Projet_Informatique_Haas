function PrintWeatherInformation(latitude,longitude,page=0){
    fetch(`https://api.open-meteo.com/v1/forecast?latitude=${latitude}&longitude=${longitude}&hourly=temperature_2m,rain,wind_speed_10m&forecast_days=7`)
        .then(response => response.json())
        .then((data) => {
            const accordion = document.querySelector("div.accordion");
            for (let i = 0;i<data.hourly.rain.length/7;i++){
                const index = 7*page+i
                let temp = getTemperatureInformation(data.hourly.temperature_2m[index]);
                let rain = getRainInformation(data.hourly.rain[index]);
                let wind = getWindInformation(data.hourly.wind_speed_10m[index])

                accordion.innerHTML +=
                    `<div class="accordion-item">
                            <h2 class="accordion-header" id="heading${i}">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse${i}" aria-expanded="true" aria-controls="collapse${i}">
                                    Donnée météo à ${i}h00 :
                                    <div class="info-bulle"><img src="/${temp.img}" class="m-2" alt="Température" width="30" height="30"><span class="texte-info">${temp.infoTemp}</span></div>
                                    <div class="info-bulle"><img src="/${rain.img}" class="m-2" alt="Pluie" width="30" height="30"><span class="texte-info">${rain.infoRain}</span></div>
                                    <div class="info-bulle"><img src="/${wind.img}" class="m-2" alt="Vent" width="30" height="30"><span class="texte-info">${wind.infoWind}</span></div>
                                </button>
                            </h2>
                            <div id="collapse${i}" class="accordion-collapse collapse show" aria-labelledby="heading${i}" data-bs-parent="#accordionWeather">
                                <div class="accordion-body">
                                    - Température : ${data.hourly.temperature_2m[index]} ${data.hourly_units.temperature_2m} <br>
                                    - Vitesse du vent : ${data.hourly.wind_speed_10m[index]} ${data.hourly_units.wind_speed_10m} <br>
                                    - Pluie : ${data.hourly.rain[index]} ${data.hourly_units.rain}
                                </div>
                            </div>
                        </div>

                        `
            }
        })
        .catch(error => {
            const div = document.querySelector("div.WeatherData");
            dataWeather = ['Erreur'];
            console.error(`Erreur lors de la requête de récupération des données : ${error}`);
        });
}

function getWindInformation(wind){
    let infoWind = "Vent Fort !"
    let img="img/big_wind.png"
    if (wind <= 10){
        img = "img/no_wind.png";
        infoWind = "Vent faible !"
    } else if (wind <= 20){
        img="img/little_wind.jpg"
        infoWind = "Vent Moyen !"
    }
    return {img,infoWind}
}

function getRainInformation(rain){
    let img="img/big_rain.jpg"
    let infoRain = "Forte pluie !"
    if (rain === 0){
        img = "img/sun.jpg";
        infoRain = "Beau soleil !"
    } else if (rain <= 0.15){
        img="img/little_rain.jpg"
        infoRain = "Faible pluie !"
    }
    return {img,infoRain}
}

function getTemperatureInformation(temperature){
    let img = "img/fire.jpg";
    let infoTemp = "Température chaude!"
    if (temperature <= 0 ) {
        img = "img/ice.jpg";
        infoTemp = "Température négative !"
    } else if (temperature <= 10) {
        img = "img/flake.png";
        infoTemp = "Température faible!"
    } else if (temperature<= 20) {
        img = "img/sun.jpg";
        infoTemp = "Température moyenne!"

    }
    return {img,infoTemp}
}

function PrintCurrentWeatherInformation(latitude,longitude){
    return fetch(`https://api.open-meteo.com/v1/forecast?latitude=${latitude}&longitude=${longitude}&hourly=temperature_2m,rain,wind_speed_10m&forecast_days=1`)
        .then(response => response.json())
        .then((data) => {
            const div = document.querySelector("div.WeatherData");
            const currentHour = new Date().getHours();
            div.innerHTML += `<div class="accordion" id="accordionWeather"> </div>`
            const accordion = document.querySelector("div.accordion");
            let temp = getTemperatureInformation(data.hourly.temperature_2m[currentHour])
            let rain = getRainInformation(data.hourly.rain[currentHour]);

            let wind = getWindInformation(data.hourly.wind_speed_10m[currentHour])
            accordion.innerHTML +=
                `<div class="accordion-item">
                            <h2 class="accordion-header" id="headingCurrent">
                              <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCurrent" aria-expanded="true" aria-controls="collapseCurrent">
                                    Donnée météo à ${currentHour}h00 :
                                    <div class="info-bulle"><img src="/${temp.img}" class="m-2" alt="Température" width="30" height="30"><span class="texte-info">${temp.infoTemp}</span></div>
                                    <div class="info-bulle"><img src="/${rain.img}" class="m-2" alt="Pluie" width="30" height="30"><span class="texte-info">${rain.infoRain}</span></div>
                                    <div class="info-bulle"><img src="/${wind.img}" class="m-2" alt="Vent" width="30" height="30"><span class="texte-info">${wind.infoWind}</span></div>
                                </button>
                            </h2>
                            <div id="collapseCurrent" class="accordion-collapse collapse show" aria-labelledby="headingCurrent" data-bs-parent="#accordionWeather">                                <div class="accordion-body">
                                    - Température : ${data.hourly.temperature_2m[currentHour]} ${data.hourly_units.temperature_2m} <br>
                                    - Vitesse du vent : ${data.hourly.wind_speed_10m[currentHour]} ${data.hourly_units.wind_speed_10m} <br>
                                    - Pluie : ${data.hourly.rain[currentHour]} ${data.hourly_units.rain}
                                </div>
                            </div>
                        </div>
                    <h1 class="m-2">Données du jour</h1>
                `
            PrintWeatherInformation(latitude,longitude,0)
})}

function ChangePictureDependingOnWeather(latitude,longitude,meter){
    return fetch(`https://api.open-meteo.com/v1/forecast?latitude=${latitude}&longitude=${longitude}&current=rain`)
        .then(response => response.json())
        .then((data) => {
            const picture = document.querySelector(`span.imgCard${meter}`);
            if (data.current.rain > 0){
                picture.innerHTML = `<img class="card-img-top" src="/img/villageRain.jpg" alt="Card image cap" >`
            }
        })
}