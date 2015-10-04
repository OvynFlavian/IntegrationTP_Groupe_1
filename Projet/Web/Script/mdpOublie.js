/**
 * Created by JulienTour on 4/10/2015.
 */
function verification_validation() {
    if (document.validation.login.value == "") {
        alert("Vous devez entrer une mot de passe !");
        document.validation.login.focus();
        return false;
    }
    if (document.validation.mdp.value == "") {
        alert("Le mot de passe est obligatoire, rentrez-le !");
        document.validation.mdp.focus();
        return false;
    }
    if (document.validation.verifmdp.value != document.newMdp.mdp.value) {
        alert("Vos deux mots de passe ne sont pas semblables !");
        document.validation.verifmdp.focus();
        return false;
    }
}
function verification_emailMdp() {
    if (document.emailMdp.email.value == "") {
        alert("L'email est obligatoire, rentrez-le !");
        document.emailMdp.email.focus();
        return false;
    }
}
