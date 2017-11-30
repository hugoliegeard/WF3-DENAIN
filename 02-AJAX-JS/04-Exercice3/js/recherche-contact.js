/*

OBJECTIF : A partir d'une liste de contacts, être en mesure de récupérer un contact et d'afficher le détail de ses informations.

CONSIGNE :

    Un internaute doit pouvoir rechercher un contact sur la base de son Username, Email, Phone ou Name
    
	Le résultat des contacts correspondant s'affiche ensuite dans une liste en dessous du champ de recherche.

    ETAPE 1. Mettre en Place le HTML et le CSS nécessaire pour rechercher un contact.
        Ex. Un champ input-text, et/ou un bouton pour lancer la recherche.
        
    ETAPE 2. Récupérer le Flux JSON : https://jsonplaceholder.typicode.com/users et être en mesure de récupérer la fiche d'un utilisateur par rapport a son username, ...
    
    ETAPE 3. Afficher en HTML et CSS uniquement les informations de base : Nom, Prénom, Email, Téléphone.
    
    
*/

// -- Les Flémards.js

// -- Chargement du DOM ...
$(function() {

    // https://stackoverflow.com/questions/15927371/what-does-debounce-do
    // https://lodash.com/docs/4.17.4#debounce
    $('#search').on('input', _.debounce((e) => {

        // -- On cache les résultats précédents
        $('.resultat').slideUp();

        let search = $('#search').val();
        let regex = new RegExp(search, 'i');

        if(search.length > 0) {
        
            // Récupération de la liste des Contacts
            $.getJSON('https://jsonplaceholder.typicode.com/users', (contacts) => {

                // console.log(contacts);
                    // for(i = 0 ; i < contacts.length ; i++) {
                    //     // -- Vérification
                    //         let contact = contacts[i];
                    //         let search  = $('#search').val();

                    //     // -- Je souhaite vérifier si un username correspond à une valeur string.
                    //     if( (contact.username == search) || (contact.email == search) || (contact.phone == search) ) {
                    //         // -- Vérification
                    //             console.log(contact.username + ' a ete trouve');
                    //             break;
                    //     }

                    // }
                
                    let resultat = _.filter(contacts, (contact) => { 
                        // return contact.username == search || contact.email == search || contact.phone == search || contact.name == search;
                        return regex.test(contact.username) || regex.test(contact.email) || regex.test(contact.phone) || regex.test(contact.name);
                    });

                    // console.log(resultat);

                    // -- Je vide mes résultats, avant d'afficher les nouveaux. De cette façon j'évite d'additionner toutes mes recherches.
                    $('.resultat').empty();

                    // -- Affichage dans la page...
                    $.each(resultat, (i, contact) => {

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

                    $('.resultat').slideDown();

            }); // $.getJSON

        } // endif
        
    } , 500)); // _.debounce
	
});
