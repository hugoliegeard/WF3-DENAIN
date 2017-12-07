<?php

# Importation de notre classe Ecole
require_once 'Ecole.class.php';

# Importation de notre classe Eleve
require_once 'Eleve.class.php';

# Importation de notre classe Classe
require_once 'Classe.class.php';

/* --
Création d'une instance de la Class Ecole
Ici, notre variable $Ecole est un Objet de Class Ecole
En ce sens, elle à accès à l'ensemble des variables et
fonction qui la compose.
-- */
$Ecole = new Ecole(
            'WF3 Denain',
            '2 Rue Louis Petit, Denain',
            'Cyrille RENARD');

# Affichage de l'Objet Ecole
var_dump($Ecole);

# Afficher le nom de l'école
# : Cannot access private property
# echo $Ecole->NomEcole;
echo $Ecole->getNomEcole();

# Je veux changer le nom de l'école ?
$Ecole->setNomEcole('Webforce3 Denain ltd');
echo '<br>'.$Ecole->getNomEcole();

# Affichage de l'Objet Ecole
var_dump($Ecole);

# Création d'Eleves
$Eleve1 = new Eleve('LELEU','Leslie',22);
$Eleve2 = new Eleve('LIEGEARD','Hugo',27);
$Eleve3 = new Eleve('DERVAUX','Yann',25);
$Eleve4 = new Eleve('DELCAMBRE','Bryan',21);

# Création des Classes
$Classe1 = new Classe('Front');
$Classe2 = new Classe('Back');
$Classe3 = new Classe('Fullstack');

# On affecte nos Eleves à leur classe
$Classe1->AjouterUnEleve($Eleve1);
$Classe1->AjouterUnEleve($Eleve2);
$Classe2->AjouterUnEleve($Eleve3);
$Classe3->AjouterUnEleve($Eleve4);

# Aperçu d'une des classes
echo '<pre>';
    print_r($Classe1);
echo '</pre>';

# Affecter les Classes à une Ecole
$Ecole->AjouterUneClasse($Classe1);
$Ecole->AjouterUneClasse($Classe2);
$Ecole->AjouterUneClasse($Classe3);

# Aperçu de l'Ecole
echo '<pre>';
print_r($Ecole);
echo '</pre>';

# Afficher mes Classes et leurs Eleves
echo '<ol>';

    # Parcourir les Classes
    $lesClasses = $Ecole->getClasses();
    foreach ($lesClasses as $objClasse) :

        echo '<li>';
            echo $objClasse->getNomClasse();
            echo '<ul>';

                # On récupère les étudiants de la Classe
                $lesEtudiants = $objClasse->getEleves();
                foreach ($lesEtudiants as $objEtudiant) :
                    echo '<li>';
                        echo $objEtudiant->getNomComplet();
                    echo '</li>';
                endforeach;

            echo '</ul>';
        echo '</li>';

    endforeach;

echo '</ol>';











