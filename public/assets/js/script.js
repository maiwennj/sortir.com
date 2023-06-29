// window.onload = init
//
// function init(){
//     document.getElementById('isTheOrganiser').addEventListener('change',hidenLinesByCheckbox)
// }
// function hidenLinesByCheckbox() {
//    let userRating = document.querySelector('.js-user');
//    let user = JSON.parse(userRating.dataset.user);
//    let check = document.getElementById("isTheOrganiser");
//    let table = document.getElementById('activity-table');
//     console.log(check.checked)
//
//     let lignes = table.getElementsByTagName('tr');
//         // console.log(lignes)
//     for (let i = 1; i < lignes.length; i++){
//         if(lignes[i].getElementsByTagName('td')[6].textContent!==user){
            // if(check){
            //     lignes[i].style.display = 'none';
            //     // lignes[i].style.color = 'blue';
            // }
            if(!check){
                // lignes[i].style.display = 'none' ;
                // lignes[i].style.color = 'red';
            }
            // lignes[i].style.display = lignes[i].style.display === 'none' ? '' : 'none';

        }
    }

}
// function testListener(valeur,champIndex, checkboxid) {
//     let checkbox = document.getElementById('isTheOrganiser')
//     let table = document.getElementById('activity-table')
//     let lines = table.getElementsByTagName('tr');
//
//     for (let i = 0; i < lines.length; i++) {
//         let champ = lines[i].getElementsByTagName('td')[7];
//         if (champ && champ.textContent.trim() === valeur) {
//             lines[i].style.display = 'none';
//         }
//     }
//
//         table.style.display = table.style.display === 'none' ? '' : 'none';
//
//
// }




// function cacherLignes(tableId, champIndex, valeur) {
//     var table = document.getElementById(tableId);
//     var lignes = table.getElementsByTagName('tr');
//
//     for (var i = 0; i < lignes.length; i++) {
//         var champ = lignes[i].getElementsByTagName('td')[champIndex];
//         if (champ && champ.textContent.trim() === valeur) {
//             lignes[i].style.display = 'none';
//         }
//     }
// }

