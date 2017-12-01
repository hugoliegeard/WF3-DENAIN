/* -------------------------------------------------------
                    LES FONCTIONS
------------------------------------------------------- */

/**
 * Validate email function with regualr expression
 * 
 * If email isn't valid then return false
 * 
 * @param email
 * @return Boolean
 */
function validateEmail(email){
	var emailReg = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
	var valid = emailReg.test(email);

	if(!valid) {
        return false;
    } else {
    	return true;
    }
}

/* -------------------------------------------------------
                    TRAITEMENT JQUERY
------------------------------------------------------- */

$(() => {
    // -- jQuery est maintenant chargé !
    console.log('jQuery is ready !');

    // -- J'écoute la soumission du Formulaire
    $('#newsletter').submit(function(e) {

        // -- Bloquer la redirection du formulaire
        e.preventDefault();

        // -- Réinitialiser les erreurs
        $('#newsletter .has-error').removeClass('has-error');
        $('#newsletter .help-block').remove();
        $('#newsletter .alert-danger').remove();

        // -- Récupération des Champs
        var email = $('#newsletter input[name="email"]');
        // console.log(email.val());

        // -- Vérifier la validité du mail
        if(!validateEmail(email.val())) {
            
            // -- Ici, mon email n'est pas valide
            email.parent().addClass('has-error');
            $('<p class="help-block">Vérifiez votre email.</p>').appendTo(email.parent());

        }

        // -- Une fois la vérification des champs terminées.
        if($('#newsletter').find('.has-error').length == 0) {

            // -- Si je n'ai pas de classe 'has-error' parmi les enfants de ma newsletter, alors il n'y a pas d'erreur et je peux procéder à ma requète AJAX

            // console.log($(this).serialize());

            $.ajax({
                type        : $(this).attr('method'),
                url         : $(this).attr('action'),
                data        : $(this).serialize(),
                dataType    : 'JSON',
                timeout     : 5000,
                beforeSend  : () => {
                    $('.isen-progress').fadeIn();
                },
                complete    : () => {
                    $('.isen-progress').fadeOut();
                }
            })
            .done((resultat) => {
                console.log('RESULT EXECUTED');
                // console.log(resultat);

                // -- Si j'ai un retour positif de mon fichier PHP, j'affiche un message de succès.
                if(resultat.success) {
                    $('#newsletter').replaceWith(`
                        <div class="alert alert-success text-center">
                            <i class="fa fa-thumbs-up fa-2x" aria-hidden="true"></i><br>
                            Merci, votre email à bien été ajouté.<br>
                            <u>A très vite dans notre prochaine newsletter !</u>
                        </div>
                    `);
                } else {

                    // -- Il y a eu un problème, nous allons vérifier d'où viens le soucis.

                    // -- On vérifie si le problème viens d'un email déjà présent en BDD
                    if(resultat.erreurs.isEmailInDb) {

                        $('#newsletter').prepend(`
                            <div class="alert alert-danger text-center">
                                <i class="fa fa-exclamation-triangle fa-2x" aria-hidden="true"></i><br>
                                Attention, votre adresse email est <u>déjà présente dans nos listes.</u>
                            </div>
                        `);                        

                        // -- Je vide le contenu de mon formulaire
                        $('#newsletter').get(0).reset();

                    }

                    if(resultat.erreurs.isEmailInvalid) {
                        
                        email.parent().addClass('has-error');
                        $('<p class="help-block">Vérifiez votre email.</p>').appendTo(email.parent());

                    }

                }
            })
            .fail((jqXHR, textStatus, errorThrown) => {
                console.log('Une erreur est survenue : ' + errorThrown);
                $('#newsletter').prepend(`
                    <div class="alert alert-danger text-center">
                        <i class="fa fa-exclamation-triangle fa-2x" aria-hidden="true"></i><br>
                        Attention, Nous n'avons pas été en mesure de traiter votre demande.<br><u>${textStatus} - ${errorThrown}</u>
                    </div>
                `);    
            });

        } else {

            // -- Sinon, il y a encore des erreurs à corriger.
            $('#newsletter').prepend(`
                <div class="alert alert-danger text-center">
                    <i class="fa fa-exclamation-triangle fa-2x" aria-hidden="true"></i><br>
                    Nous n'avons pas été en mesure de valider votre demande.
                    <u>Vérifiez vos informations.</u>
                </div>
            `);

        }

    }); // submit('newsletter')

}); // jquery(function())