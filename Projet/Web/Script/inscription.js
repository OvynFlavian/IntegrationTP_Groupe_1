/**
 * Created by JulienTour on 3/10/2015.
 */
function verification_inscription() {
    if (document.getElementById('userName').value == "") {
        alert("Le login est obligatoire, rentrez-le !");
        document.formulaire.userName.focus();
        return false;
    }
    if (document.getElementById('email').value == "") {
        alert("L'email est obligatoire, rentrez-le !");
        document.formulaire.email.focus();
        return false;
    }
    if (document.getElementById('mdp').value == "") {
        alert("Le mdp est obligatoire, rentrez-le !");
        document.formulaire.mdp.focus();
        return false;
    }
    if (document.getElementById('emailConfirm').value != document.getElementById('email').value) {
        alert("La vérification de l'email ne correspond pas, corrigez-le !");
        document.formulaire.emailConfirm.focus();
        return false;
    }
    if (document.getElementById('mdpConfirm').value != document.getElementById('mdp').value) {
        alert("La vérification du mot de passe ne correspond pas, corrigez-le !");
        document.formulaire.mdpConfirm.focus();
        return false;
    }
}