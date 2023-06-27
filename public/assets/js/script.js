window.onload = init

function init(){
    document.getElementById('select-city').addEventListener('change',selectCity)
}

function selectCity(){
    let selectedCity = document.getElementById("select-city")
    let choice = selectedCity.selectedIndex
    console.log(choice)
}