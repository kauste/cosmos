import "bootstrap";
import axios from "axios";
axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

const countryInputDOM = document.querySelector(".country--name");
if(document.querySelector('button')){
    const buttons = document.querySelectorAll('button');
    buttons.forEach(button => {
        button.addEventListener('click', () => {
            button.setAttribute('disabled', '');
            button.closest('form').submit();
        });
    });
}
if (countryInputDOM) {
    countryInputDOM.addEventListener("input", (e) => {
        axios.get("https://restcountries.com/v3.1/name/" + e.target.value.toLowerCase() + "?fields=name")
            .then((res) => {
                const completedDOM = document.querySelector("#completed-countries");
                let countries = res.data;
                let completeCountries = [];
                let completeHTML = "";

                countries.sort((a, b) => a.name.common.localeCompare(b.name.common));
                countries = countries.filter(
                    (country) =>
                        country.name.common.slice(0, e.target.value.length).toLowerCase() === e.target.value.toLowerCase());

                for (let i = 0; countries.length < 5 ? i < countries.length : i < 5; i++) {
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
    const longitudeAvailibleDOM = document.querySelector(".availible--longitude");
    const dontShowLongBtnDOM = document.querySelector(".dont--longitude--button");
    //latitudes
    const latitudeInputDOM = document.querySelector("input[name='latitude']");
    const latitudeButtonDOM = document.querySelector(".latitude--button");
    const latitudeAvailibleDOM = document.querySelector(".availible--latitude");
    const dontShowLatitudeBtnDOM = document.querySelector(".dont--latitude--button");

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
        if ((longitudeInputDOM.value == "" && latitudeInputDOM.value == "") ||
            (longitudeInputDOM.value != "" && latitudeInputDOM.value != "")) 
        {
            longitudeButtonDOM.classList.add("d-none");
            latitudeButtonDOM.classList.add("d-none");
        }
        if (longitudeInputDOM.value != "" && latitudeInputDOM.value == "") {
            latitudeButtonDOM.classList.remove("d-none");
            longitudeButtonDOM.classList.add("d-none");
            showLatitudes();
        }
        if (longitudeInputDOM.value == "" && latitudeInputDOM.value != "") {
            longitudeButtonDOM.classList.remove("d-none");
            latitudeButtonDOM.classList.add("d-none");
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
}
   
    
const addCheckbox = (props) => {
    if (props.countryId != null) {
        axios.get(props.url + "?countryId=" + props.countryId + (props.pageElementId != false ? "&" + props.querry+ "=" + props.pageElementId : ""))
        .then((res) => {
            props.innerHtmlRowDOM.firstElementChild.innerHTML = `<div>${res.data.countryName}'s ${props.elementForInclude}s:</div>
                                                                 <small class="no-variables">Not necessary. You will be able to add your own ${props.elementForInclude}.</small>`;
                let html = "";
                console.log(res.data);
                res.data[props.dataProp].forEach((element) => {
                    html += `<li style="list-style:none">
                                    <input id="${element.id}" type="checkbox" name="add-${props.elementForInclude}[]" value="${element.id}" ${res.data[props.checkedProp].includes(element.id) ? 'checked' : ''}>
                                    <label for="${element.id}">${element[props.nameProp]}</label>
                            </li>`;
                });
                if (html != "") {
                    props.innerHtmlRowDOM.querySelector("ul").innerHTML = html;
                } else {
                    props.innerHtmlRowDOM.querySelector("ul").innerHTML =
                        `<li style="list-style:none" class="col-form-label no-variables">This country do not have any ${props.elementForInclude} yet.</li>`;
                 }
            props.innerHtmlRowDOM.classList.remove("d-none");
            props.innerHtmlRowDOM.classList.add("d-flex");
         });
    } else {
        props.innerHtmlRowDOM.firstElementChild.innerHTML = "";
        props.innerHtmlRowDOM.querySelector("ul").innerHTML = "";
        props.innerHtmlRowDOM.classList.add("d-none");
        props.innerHtmlRowDOM.classList.remove("d-flex");
    }
};

     // ships
if (document.querySelector("input[name='longitude']")) {
    const chosenCountryDOM = document.querySelector('[name="country"]');
    const mineIdDOM = document.querySelector('[name="mine-name"]');
    const countriesShipsRowDOM = document.querySelector(".countries--ships");
    let thisMineId = false;
    if (mineIdDOM.dataset.mineId) {
        thisMineId = mineIdDOM.dataset.mineId;
    }
    const countryShipsData = {
        url : countryAndShipsUrl,
        pageElementId : thisMineId,
        querry : 'mineId',
        innerHtmlRowDOM : countriesShipsRowDOM,
        elementForInclude : 'ship',
        dataProp: 'ships',
        checkedProp: 'minesShips',
        nameProp : 'ship_name',
    }
    chosenCountryDOM.addEventListener("change", (event) => {
        countryShipsData.countryId = event.target.value,
       addCheckbox(countryShipsData);
    });
    if (chosenCountryDOM.value != '') {
        countryShipsData.countryId = chosenCountryDOM.value;
       addCheckbox(countryShipsData);
    }
}
if (document.querySelector(".countries--mines")) {
    const chosenCountryDOM = document.querySelector('[name="country"]');
    const shipIdDOM = document.querySelector('[name="ship-name"]');
    const countriesMinesRowDOM = document.querySelector(".countries--mines");
    let thisShipId = false;
    if (shipIdDOM.dataset.shipId) {
        thisShipId = shipIdDOM.dataset.shipId;
    }
    const countryMinesData = {
        url : countryAndMinesUrl,
        pageElementId : thisShipId,
        querry : 'shipId',
        innerHtmlRowDOM : countriesMinesRowDOM,
        elementForInclude : 'mine',
        dataProp: 'mines',
        checkedProp: 'shipsMines',
        nameProp : 'mine_name',
    }
    chosenCountryDOM.addEventListener("change", (event) => {
        countryMinesData.countryId = event.target.value,
       addCheckbox(countryMinesData);
    });
    if (chosenCountryDOM.value != '') {
        countryMinesData.countryId = chosenCountryDOM.value;
        addCheckbox(countryMinesData);
    }
}

    
    // const addCountryShip = (url, countryId, elemetId, innerHtmlRowDOM, dataProp, nameProp) => {
    //     if (countryId != null) {
    //         axios.get(url + "?countryId=" + countryId + (elemetId != false ? "&shipId=" + elemetId : ""))
    //             .then((res) => {
    //                 innerHtmlRowDOM.firstElementChild.innerHTML = `<div>${res.data.countryName}'s mines:</div>
    //                                                              <small class="no-variables">Not necessary. You will be able to add your own mines.</small>`;
    //                 let html = "";
    //                 res.data[dataProp].forEach((element) => {
    //                     html += `<li style="list-style:none">
    //                                 <input id="${element.id}" type="checkbox" name="add-mine[]" value="${element.id}" ${res.data.shipsMines.includes(element.id) ? 'checked' : ''}>
    //                                 <label for="${element.id}">${element[nameProp]}</label>
    //                         </li>`;
    //                 });
    //                 if (html != "") {
    //                     innerHtmlRowDOM.querySelector("ul").innerHTML = html;
    //                 } else {
    //                     innerHtmlRowDOM.querySelector("ul").innerHTML =
    //                         '<li style="list-style:none" for="add-mine" class="col-form-label no-variables">This country did not buy any mine yet.</li>';
    //                 }
    //                 innerHtmlRowDOM.classList.remove("d-none");
    //                 innerHtmlRowDOM.classList.add("d-flex");
    //             });
    //     } else {
    //         innerHtmlRowDOM.firstElementChild.innerHTML = "";
    //         innerHtmlRowDOM.querySelector("ul").innerHTML = "";
    //         innerHtmlRowDOM.classList.add("d-none");
    //         innerHtmlRowDOM.classList.remove("d-flex");
    //     }
    // };
