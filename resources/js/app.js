import "bootstrap";
import axios from "axios";
import { remove, upperFirst } from "lodash";

axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

const countryInputDOM = document.querySelector(".country--name");

if (countryInputDOM) {
    countryInputDOM.addEventListener("input", (e) => {
        axios
            .get(
                "https://restcountries.com/v3.1/name/" +
                    e.target.value.toLowerCase() +
                    "?fields=name"
            )
            .then((res) => {
                const completedDOM = document.querySelector(
                    "#completed-countries"
                );
                let countries = res.data;
                let completeCountries = [];
                let completeHTML = "";

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
//mines create and edit
if (document.querySelector("input[name='longitude']")) {
    //buttons

    //longitudes
    const longitudeInputDOM = document.querySelector("input[name='longitude']");
    const longitudeButtonDOM = document.querySelector(".longitude--button");
    const longitudeAvailibleDOM = document.querySelector(
        ".availible--longitude"
    );
    const dontShowLongBtnDOM = document.querySelector(
        ".dont--longitude--button"
    );
    //latitudes
    const latitudeInputDOM = document.querySelector("input[name='latitude']");
    const latitudeButtonDOM = document.querySelector(".latitude--button");
    const latitudeAvailibleDOM = document.querySelector(".availible--latitude");
    const dontShowLatitudeBtnDOM = document.querySelector(
        ".dont--latitude--button"
    );

    //longitudes
    const longitudesRemove = () => {
        if (longitudeAvailibleDOM.innerHTML != "") {
            longitudeAvailibleDOM.innerHTML = "";
            dontShowLongBtnDOM.classList.add("d-none");
        }
    };
    const dontShowLongitudes = () => {
        dontShowLongBtnDOM.classList.remove("d-none");
        dontShowLongBtnDOM.addEventListener("click", () => {
            longitudesRemove();
            longitudeButtonDOM.classList.remove("d-none");
        });
    };
    const longitudesToHtml = () => {
        longitudeButtonDOM.classList.add("d-none");
        axios
            .get(showLongitudeUrl + "?latitude=" + latitudeInputDOM.value)
            .then((res) => {
                const longitudes = res.data.longitudes;
                console.log(longitudes);
                let longitudesHTML = "";
                longitudes.forEach((longitude) => {
                    longitudesHTML += longitude + " ";
                });
                longitudeAvailibleDOM.innerHTML =
                    "<small>" + longitudesHTML + "</small>";
            });
        dontShowLongitudes();
    };
    const showLongitudes = () => {
        longitudeButtonDOM.addEventListener("click", longitudesToHtml);
    };
    //latitudes
    const latitudesRemove = () => {
        if (latitudeAvailibleDOM.innerHTML != "") {
            latitudeAvailibleDOM.innerHTML = "";
            dontShowLatitudeBtnDOM.classList.add("d-none");
        }
    };
    const dontShowLatitudes = () => {
        dontShowLatitudeBtnDOM.classList.remove("d-none");
        dontShowLatitudeBtnDOM.addEventListener("click", () => {
            latitudesRemove();
            latitudeButtonDOM.classList.remove("d-none");
        });
    };
    const latitudesToHtml = () => {
        latitudeButtonDOM.classList.add("d-none");
        axios
            .get(showLatitudeUrl + "?longitude=" + longitudeInputDOM.value)
            .then((res) => {
                const latitudes = res.data.latitudes;
                let latitudesHTML = "";
                console.log(
                    showLatitudeUrl + "?longitude=" + longitudeInputDOM.value
                );
                latitudes.forEach((latitude) => {
                    latitudesHTML += latitude + " ";
                });
                latitudeAvailibleDOM.innerHTML =
                    "<small>" + latitudesHTML + "</small>";
            });
        dontShowLatitudes();
    };
    const showLatitudes = () => {
        latitudeButtonDOM.addEventListener("click", latitudesToHtml);
    };
    //when to show button
    const buttonChange = () => {
        longitudesRemove();
        latitudesRemove();
        if (
            (longitudeInputDOM.value == "" && latitudeInputDOM.value == "") ||
            (longitudeInputDOM.value != "" && latitudeInputDOM.value != "")
        ) {
            if (!longitudeButtonDOM.classList.contains("d-none")) {
                longitudeButtonDOM.classList.add("d-none");
            }
            if (!latitudeButtonDOM.classList.contains("d-none")) {
                latitudeButtonDOM.classList.add("d-none");
            }
        }
        if (longitudeInputDOM.value != "" && latitudeInputDOM.value == "") {
            if (longitudeButtonDOM.classList.contains("d-none")) {
                latitudeButtonDOM.classList.remove("d-none");
            }
            if (!latitudeButtonDOM.classList.contains("d-none")) {
                longitudeButtonDOM.classList.add("d-none");
            }
            showLatitudes();
        }
        if (longitudeInputDOM.value == "" && latitudeInputDOM.value != "") {
            if (longitudeButtonDOM.classList.contains("d-none")) {
                longitudeButtonDOM.classList.remove("d-none");
            }
            if (latitudeButtonDOM.classList.contains("d-none")) {
                latitudeButtonDOM.classList.add("d-none");
            }
            showLongitudes();
        }
    };
    latitudeInputDOM.addEventListener("input", () => {
        longitudeButtonDOM.removeEventListener("click", longitudesToHtml);
        buttonChange();
    });
    longitudeInputDOM.addEventListener("input", () => {
        latitudeButtonDOM.removeEventListener("click", latitudesToHtml);
        buttonChange();
    });

    // ships
    const chosenCountryDOM = document.querySelector('[name="country"]');
    const mineIdDOM = document.querySelector('[name="mine-name"]');
    const countriesSipsRowDOM = document.querySelector(".countries--ships");
    const addCountryShip = (url, countryId, mineId) => {
        if (countryId != null) {
            axios.get(url + "?countryId=" + countryId + (mineId != false ? "&mineId=" + mineId : ""))
                .then((res) => {
                    countriesSipsRowDOM.firstElementChild.innerHTML = `<div>${res.data.countryName}'s ships:</div>
                                                                 <small class="no-variables">Not necessary. You will be able to add your own ship.</small>`;
                    let html = "";
                    res.data.ships.forEach((ship) => {
                        html += `<li style="list-style:none">
                                    <input id="${ship.id}" type="checkbox" name="add-ship[]" value="${ship.id}" ${res.data.minesShips.includes(ship.id) ? 'checked' : ''}>
                                    <label for="${ship.id}">${ship.ship_name}</label>
                            </li>`;
                    });
                    if (html != "") {
                        countriesSipsRowDOM.querySelector("ul").innerHTML = html;
                    } else {
                        countriesSipsRowDOM.querySelector("ul").innerHTML =
                            '<li style="list-style:none" for="add-mine" class="col-form-label no-variables">This country did not buy any ship yet.</li>';
                    }
                    countriesSipsRowDOM.classList.remove("d-none");
                    countriesSipsRowDOM.classList.add("d-flex");
                });
        } else {
            countriesSipsRowDOM.firstElementChild.innerHTML = "";
            countriesSipsRowDOM.querySelector("ul").innerHTML = "";
            countriesSipsRowDOM.classList.add("d-none");
            countriesSipsRowDOM.classList.remove("d-flex");
        }
    };
    chosenCountryDOM.addEventListener("change", (event) => {
        let thisMineId = false;
        if (mineIdDOM.dataset.mineId) {
            thisMineId = mineIdDOM.dataset.mineId;
        }
        addCountryShip(countryAndShipsUrl, event.target.value, thisMineId);
    });
    if (chosenCountryDOM.value != '') {
        let thisMineId = false;
        if (mineIdDOM.dataset.mineId) {
            thisMineId = mineIdDOM.dataset.mineId;
        }
        addCountryShip(countryAndShipsUrl, chosenCountryDOM.value, thisMineId);
    }
}
if (document.querySelector(".countries--mines")) {
    const chosenCountryDOM = document.querySelector('[name="country"]');
    const shipIdDOM = document.querySelector('[name="ship-name"]');
    const countriesMinesRowDOM = document.querySelector(".countries--mines");
    const addCountryShip = (url, countryId, shipId) => {
        if (countryId != null) {
            axios.get(url + "?countryId=" + countryId + (shipId != false ? "&shipId=" + shipId : ""))
                .then((res) => {
                    countriesMinesRowDOM.firstElementChild.innerHTML = `<div>${res.data.countryName}'s mines:</div>
                                                                 <small class="no-variables">Not necessary. You will be able to add your own mines.</small>`;
                    let html = "";
                    res.data.mines.forEach((mine) => {
                        html += `<li style="list-style:none">
                                    <input id="${mine.id}" type="checkbox" name="add-mine[]" value="${mine.id}" ${res.data.shipsMines.includes(mine.id) ? 'checked' : ''}>
                                    <label for="${mine.id}">${mine.mine_name}</label>
                            </li>`;
                    });
                    if (html != "") {
                        countriesMinesRowDOM.querySelector("ul").innerHTML = html;
                    } else {
                        countriesMinesRowDOM.querySelector("ul").innerHTML =
                            '<li style="list-style:none" for="add-mine" class="col-form-label no-variables">This country did not buy any mine yet.</li>';
                    }
                    countriesMinesRowDOM.classList.remove("d-none");
                    countriesMinesRowDOM.classList.add("d-flex");
                });
        } else {
            countriesMinesRowDOM.firstElementChild.innerHTML = "";
            countriesMinesRowDOM.querySelector("ul").innerHTML = "";
            countriesMinesRowDOM.classList.add("d-none");
            countriesMinesRowDOM.classList.remove("d-flex");
        }
    };
    chosenCountryDOM.addEventListener("change", (event) => {
        let thisShipId = false;
        if (shipIdDOM.dataset.shipId) {
            thisShipId = shipIdDOM.dataset.shipId;
        }
        addCountryShip(countryAndMinesUrl, event.target.value, thisShipId);
    });
    if (chosenCountryDOM.value != '') {
        let thisShipId = false;
        if (shipIdDOM.dataset.shipId) {
            thisShipId = shipIdDOM.dataset.shipId;
        }
        addCountryShip(countryAndMinesUrl, chosenCountryDOM.value, thisShipId);
    }
}
