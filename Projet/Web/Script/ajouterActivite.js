/**
 * Created by JulienTour on 18/10/2015.
 */
function verification_ajouterActivite() {
    if (document.getElementById('activite').value == "") {
        alert("Rentrez une activité pour pouvoir continuer !");
        document.getElementById('activite').focus();
        return false;
    }
}