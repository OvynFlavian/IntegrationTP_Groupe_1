/**
 * Created by JulienTour on 3/10/2015.
 */
function verification_connexion() {
    if (document.formulaire.userName.value == "") {
        alert("Le login est obligatoire, rentrez-le !");
        document.formulaire.userName.focus();
        return false;
    }
    if (document.formulaire.mdp.value == "") {
        alert("Le mot de passe est obligatoire, rentrez-le !");
        document.formulaire.mdp.focus();
        return false;
    }
}