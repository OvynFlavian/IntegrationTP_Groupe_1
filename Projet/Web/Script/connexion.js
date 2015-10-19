/**
 * Created by JulienTour on 3/10/2015.
 */
function verification_connexion() {
    if (document.getElementById('userName').value == "") {
        alert("Le login est obligatoire, rentrez-le !");
        document.formulaire.userName.focus();
        return false;
    }
    if (document.getElementById('mdp').value == "") {
        alert("Le mot de passe est obligatoire, rentrez-le !");
        document.formulaire.mdp.focus();
        return false;
    }
}