// -- Initialisation de jQuery
$(function() {
    console.log('jQuery is Ready !');

    // -- Je vais écouter l'évènement change sur le champ input pour capter la saisie de mon utilisateur.

    // $('#search').on('change', function(e) {}) OU :
    $('#search').on('input', _.debounce((e) => {

        // -- Je récupère la valeur saisie par mon utilisateur
        let search = $('#search').val();
        let regex  = new RegExp(search, 'i');

        $('.resultat').slideUp();

        // -- Vérification dans la console.
        // console.log(search);
        
        // -- Je veux enclencher ma requète à l'API que si mon utilisateur a saisie une information dans le champ "search"
        if(search.length > 0) {

            // -- Récupération de ma liste de contact
            $.getJSON('https://jsonplaceholder.typicode.com/users', (contacts) => {
                
                // console.log(contacts);

                // for(let i = 0 ; i < contacts.length ; i++) {

                //     let contact = contacts[i];
                //     // console.log(contact);

                //     // -- Je souhaite vérifier si un username OU un name OU un email OU un phone correspond à une valeur string de mon "contact"

                //     if(contact.username == search || contact.name == search || contact.phone == search || contact.email == search) 
                //     {
                //         console.log(contact.username + ' a été trouvé !');
                //         // break;
                //     } // End If

                // } // End For

                let resultat = _.filter(contacts, (contact) => {
                    return regex.test(contact.username) || regex.test(contact.email) || regex.test(contact.phone) || regex.test(contact.name);
                });

                // console.log(resultat);

                // -- Je vide mes résultats avant d'afficher les nouveaux. De cette façon j'évite d'additionner toutes mes recherches.
                $('.resultat').empty();

                // -- Affichage dans la page, je parcours mon tableau de contact filtré.
                // $.each(resultat, (i, contact) => {})
                _.forEach(resultat, (contact) => {
                    
                    // -- Pour chaque contact dans le tableau, je met en place une structure HTML que j'injecte dans ma div class resultat.
                    $(`
                        <div class="membre">
                            <div class="membre_informations">
                                <p>Nom Complet : ${contact.name}</p>
                                <p>Username : ${contact.username}</p>
                                <p>Email : ${contact.email}</p>
                                <p>Téléphone : ${contact.phone}</p>
                            </div>
                        </div>
                    `).appendTo($('.resultat'));

                });

                // -- Mark JS & Affichage du Résultat 
                $('.resultat').unmark().mark(search);
                $('.resultat').slideDown();

            }); // $.getJSON()

        } // end if search > 0

    }, 500 )); // .on('change) _.debounce();

}); // $(function())