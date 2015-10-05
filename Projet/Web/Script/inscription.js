/**
 * Created by JulienTour on 3/10/2015.
 */
function verification_inscription() {
    if (document.formulaire.userName.value == "") {
        alert("Le login est obligatoire, rentrez-le !");
        document.formulaire.userName.focus();
        return false;
    }
    if (document.formulaire.email.value == "") {
        alert("L'email est obligatoire, rentrez-le !");
        document.formulaire.email.focus();
        return false;
    }
    if (document.formulaire.mdp.value == "") {
        alert("Le mdp est obligatoire, rentrez-le !");
        document.formulaire.mdp.focus();
        return false;
    }
    if (document.formulaire.emailConfirm.value != document.formulaire.email.value) {
        alert("La vérification de l'email ne correspond pas, corrigez-le !");
        document.formulaire.emailConfirm.focus();
        return false;
    }
    if (document.formulaire.mdpConfirm.value != document.formulaire.mdp.value) {
        alert("La vérification du mot de passe ne correspond pas, corrigez-le !");
        document.formulaire.mdpConfirm.focus();
        return false;
    }
}