import 'bootstrap';
import axios from 'axios';

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

const countryInputDOM = document.querySelector('.country--name');

if(countryInputDOM){
    countryInputDOM.addEventListener('input', (e) => {
        axios.get('https://restcountries.com/v3.1/name/'+ (e.target.value).toLowerCase() +'?fields=name')
        .then(res => {
            const completedDOM = document.querySelector('#completed-countries');
            let countries = res.data;
            let completeCountries = [];
            let completeHTML = '';

            countries.sort((a, b) => a.name.common.localeCompare(b.name.common));
            countries = countries.filter((country) => (country.name.common).slice(0, (e.target.value).length).toLowerCase() === (e.target.value).toLowerCase())            
            
            for(let i = 0; (countries.length < 5) ? (i < countries.length) : (i < 5); i++){
                completeCountries.push(countries[i].name.common);
            }
            console.log(completeCountries.length)
            if(completeCountries.length){
                completeCountries.forEach(country => {
                    completeHTML += '<option value="' + country + '">';
                });
                completedDOM.innerHTML = completeHTML;
                console.log('if' + completedDOM.innerHTML);
            }
            else {
                completedDOM.innerHTML ='<option value="No countries" disabled/>';
                console.log('else' + completedDOM.innerHTML);
            }
        })
        .catch((error) => {
            const completedDOM = document.querySelector('#completed-countries');
            if(error.response && error.response.status === 404) {
                completedDOM.innerHTML ='<option value="No countries" disabled="disabled"/>';
                console.log(error.response + completedDOM.innerHTML);

            }
        })
    });
}
    
    
