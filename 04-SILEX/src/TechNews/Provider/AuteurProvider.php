<?php

namespace TechNews\Provider;

use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use TechNews\Model\Auteur;

class AuteurProvider implements UserProviderInterface
{

    private $_db;

    /**
     * Récupération de l'instance de la BDD
     * @param $db Idiorm ou Doctrine DBAL
     */
    public function __construct($db)
    {
        $this->_db = $db;
    }

    /**
     * Loads the user for the given username.
     *
     * This method must throw UsernameNotFoundException if the user is not
     * found.
     *
     * @param string $EMAILAUTEUR The username
     *
     * @return UserInterface
     *
     * @throws UsernameNotFoundException if the user is not found
     */
    public function loadUserByUsername($EMAILAUTEUR)
    {
        # Je récupère l'auteur par rapport a son username
        $auteur = $this->_db->for_table('auteur')
                ->where('EMAILAUTEUR', $EMAILAUTEUR)
                ->find_one();

        # Je vérifie que l'utilisateur soit trouvé.
        if(empty($auteur)) :
           throw new UsernameNotFoundException(
                sprintf('Cet utilisateur "%s" n\'existe pas.',
                    $EMAILAUTEUR)
           );
        endif;

        # Si tout est bon, je retourne une instance de Auteur
        return new Auteur($auteur->IDAUTEUR, $auteur->NOMAUTEUR,
            $auteur->PRENOMAUTEUR, $auteur->EMAILAUTEUR,
            $auteur->MDPAUTEUR, $auteur->ROLEAUTEUR);

    }

    /**
     * Refreshes the user.
     *
     * It is up to the implementation to decide if the user data should be
     * totally reloaded (e.g. from the database), or if the UserInterface
     * object can just be merged into some internal array of users / identity
     * map.
     *
     * @return UserInterface
     *
     * @throws UnsupportedUserException if the user is not supported
     */
    public function refreshUser(UserInterface $auteur)
    {
        # On s'assure de bien avoir un Objet Auteur
        if(!$auteur instanceof Auteur) :
            throw new UnsupportedUserException(
                sprintf('Les instance de "%s" ne sont pas autorisées.',
                    getClass($auteur))
            );
        endif;

        # Si tous est correct, je peux charger l'utilisateur via son username.
        return $this->loadUserByUsername($auteur->getUsername());
    }

    /**
     * Whether this provider supports the given user class.
     *
     * @param string $class
     *
     * @return bool
     */
    public function supportsClass($class)
    {
        return $class === 'TechNews\Model\Auteur';
    }
}