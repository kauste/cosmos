import "bootstrap";
import axios from "axios";
import { remove, upperFirst } from "lodash";

axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

const countryInputDOM = document.querySelector('.country--name');

if (countryInputDOM) {
    countryInputDOM.addEventListener('input', (e) => {
        axios
            .get(
                'https://restcountries.com/v3.1/name/' +
                    e.target.value.toLowerCase() +
                    '?fields=name'
            )
            .then((res) => {
                const completedDOM = document.querySelector(
                    '#completed-countries'
                );
                let countries = res.data;
                let completeCountries = [];
                let completeHTML = '';

                countries.sort((a, b) =>
                    a.name.common.localeCompare(b.name.common)
                );
                countries = countries.filter(
                    (country) =>
                        country.name.common
                            .slice(0, e.target.value.length)
                            .toLowerCase() === e.target.value.toLowerCase()
                );

                for (
                    let i = 0;
                    countries.length < 5 ? i < countries.length : i < 5;
                    i++
                ) {
                    completeCountries.push(countries[i].name.common);
                }
                // console.log(completeCountries.length)
                if (completeCountries.length) {
                    completeCountries.forEach((country) => {
                        completeHTML += '<option value="' + country + '">';
                    });
                    completedDOM.innerHTML = completeHTML;
                    console.log(completedDOM);
                }
                // else {
                //     completedDOM.innerHTML = '<option value="Nocountries"/>';
                //     console.log('else' + completedDOM.innerHTML);
                // }
            })
            .catch(() => {
                // setTimeout(() => {
                //     const completedDOM = document.querySelector('#completed-countries');
                //     let completeHTML = '';
                //     [1,5,7].forEach(country => {
                //         completeHTML += '<option value="' + country + '">';
                //     });
                //     completedDOM.innerHTML = completeHTML;
                //     console.log( completedDOM);
                //     console.log('hello')
                // }, 100 )
                // const completedDOM = document.querySelector('#completed-countries');
                // if(error.response && error.response.status === 404) {
                // completedDOM.innerHTML = '<option value="No countries">No countries</option>';
                // }
            });
    });
}
if (document.querySelector("input[name='longitude']")) {
    //longitudes
    const longitudeInputDOM = document.querySelector("input[name='longitude']");
    const longitudeButtonDOM = document.querySelector('.longitude--button');
    const longitudeAvailibleDOM = document.querySelector('.availible--longitude');
    const dontShowLongBtnDOM = document.querySelector('.dont--longitude--button');
   //latitudes
    const latitudeInputDOM = document.querySelector("input[name='latitude']");
    const latitudeButtonDOM = document.querySelector('.latitude--button');
    const latitudeAvailibleDOM = document.querySelector('.availible--latitude');
    const dontShowLatitudeBtnDOM = document.querySelector('.dont--latitude--button');

    const showLongitudes = () => {
        longitudeButtonDOM.addEventListener('click', () => {
            longitudeButtonDOM.classList.add('d-none');
            axios.get(showLongitudeUrl + '?latitude=' + latitudeInputDOM.value)
                .then((res) => {
                    const longitudes = res.data.longitudes;
                    console.log(longitudes);
                    let longitudesHTML = '';
                    longitudes.forEach((longitude) => {
                        longitudesHTML += longitude + ' ';
                    });
                    longitudeAvailibleDOM.innerHTML =
                        '<small>' + longitudesHTML + '</small>';
                    });
                    dontShowLongitudes();
        });
    };
    const longitudesRemove = () => {
        if(longitudeAvailibleDOM.innerHTML != ''){
            longitudeAvailibleDOM.innerHTML = '';
            dontShowLongBtnDOM.classList.add('d-none');
        }
    }
    const dontShowLongitudes = () => {
        dontShowLongBtnDOM.classList.remove('d-none');
        dontShowLongBtnDOM.addEventListener('click', () => {
            longitudesRemove();
            longitudeButtonDOM.classList.remove('d-none');
        });
    };

    const showLatitudes = () => {
        latitudeButtonDOM.addEventListener('click', () => {
            latitudeButtonDOM.classList.add('d-none');
            axios.get(showLatitudeUrl + '?longitude=' + longitudeInputDOM.value)
                .then((res) => {
                    const latitudes = res.data.latitudes;
                    console.log(latitudes);
                    let latitudesHTML = '';
                    latitudes.forEach((latitude) => {
                        latitudesHTML += latitude + ' ';
                    });
                    latitudeAvailibleDOM.innerHTML =
                        '<small>' + latitudesHTML + '</small>';
                    });
                    dontShowLatitudes();
        });
    };
    const latitudesRemove = () => {
        if(latitudeAvailibleDOM.innerHTML != ''){
            latitudeAvailibleDOM.innerHTML = '';
            dontShowLatitudeBtnDOM.classList.add('d-none');
        } 
    }
    const dontShowLatitudes = () => {
        dontShowLatitudeBtnDOM.classList.remove('d-none');
        dontShowLatitudeBtnDOM.addEventListener('click', () => {
            latitudesRemove();
            latitudeButtonDOM.classList.remove('d-none')
        });
    };
    const buttonChange = () => {
            longitudesRemove();
            latitudesRemove();
        if (
            (longitudeInputDOM.value == '' && latitudeInputDOM.value == '') ||
            (longitudeInputDOM.value != '' && latitudeInputDOM.value != '')
        ) {
            
            if (!longitudeButtonDOM.classList.contains('d-none')) {
                longitudeButtonDOM.classList.add('d-none');
            }
            if (!latitudeButtonDOM.classList.contains('d-none')) {
                latitudeButtonDOM.classList.add('d-none');
            }
        }
        if (longitudeInputDOM.value != '' && latitudeInputDOM.value == '') {
            if (longitudeButtonDOM.classList.contains('d-none')) {
                latitudeButtonDOM.classList.remove('d-none');
            }
            if (!latitudeButtonDOM.classList.contains('d-none')) {
                longitudeButtonDOM.classList.add('d-none');
            }
            showLatitudes();
        }
        if (longitudeInputDOM.value == '' && latitudeInputDOM.value != '') {
            if (longitudeButtonDOM.classList.contains('d-none')) {
                longitudeButtonDOM.classList.remove('d-none');
            }
            if (latitudeButtonDOM.classList.contains('d-none')) {
                latitudeButtonDOM.classList.add('d-none');
            }
            showLongitudes();
        }
    };
    latitudeInputDOM.addEventListener('input', () => {
        buttonChange();
    });
    longitudeInputDOM.addEventListener('input', () => {
        buttonChange();
    });
}

