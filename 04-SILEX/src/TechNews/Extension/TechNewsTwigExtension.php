<?php

namespace TechNews\Extension;


use TechNews\Helper;

class TechNewsTwigExtension extends \Twig_Extension
{
    # : https://twig.symfony.com/doc/2.x/advanced.html#creating-an-extension
    # : https://twig.symfony.com/doc/2.x/advanced.html#id3

    use Helper;

    /**
     * Création des Filtres Accroche et "Slugify"
     * @return array|\Twig_Filter[]|void
     */
    public function getFilters()
    {
        return [
            new \Twig_Filter('accroche',function($text) {

                # Supprimer toutes les balises HTML
                $string = strip_tags($text);

                # Si ma chaine de caractère est supérieur à 170
                # Je poursuis, sinon c'est inutile
                if(strlen($string) > 170) :

                    # Je coupe ma chaine à 170.
                    $stringCut = substr($string, 0, 170);

                    # Je m'assure que je ne coupe pas de mot !
                    $string = substr($stringCut, 0,
                        strrpos($stringCut, ' '));

                endif;

                # On retourne l'accroche
                return $string . '...';

            }), # -- Fin de Twig Filter Accroche

            new \Twig_Filter('slugify', function($text) {

                return $this->slugify($text);

            }) # -- Fin de Twig Filter Slugify

        ]; # -- Fin du Array

    }  # -- Fin de getFilters

} # -- Fin de la Classe TchNewsTwigExtension

# -- Fin du Fichier ^^
#
#
#
#
#
#
#
#
#
#
#
#
#
#
#
#
#
# -- Fin de la Vie... -_-