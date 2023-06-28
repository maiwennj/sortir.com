window.onload = init

function init(){
    document.getElementById('isTheOrganiser').addEventListener('change',testListener)
}

function testListener() {
    let checkbox = document.getElementById('isTheOrganiser')
    let table = document.getElementById('activity-table')


        table.style.display = table.style.display === 'none' ? '' : 'none';


}




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
