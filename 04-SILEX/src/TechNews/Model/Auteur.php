<?php

namespace TechNews\Model;


use Symfony\Component\Security\Core\User\UserInterface;

class Auteur implements UserInterface
{

    # Définition des Propriétés
    private $IDAUTEUR,
            $NOMAUTEUR,
            $PRENOMAUTEUR,
            $EMAILAUTEUR,
            $MDPAUTEUR,
            $ROLEAUTEUR;

    /**
     * Auteur constructor.
     * @param $IDAUTEUR
     * @param $NOMAUTEUR
     * @param $PRENOMAUTEUR
     * @param $EMAILAUTEUR
     * @param $MDPAUTEUR
     * @param $ROLEAUTEUR
     */
    public function __construct($IDAUTEUR, $NOMAUTEUR, $PRENOMAUTEUR, $EMAILAUTEUR, $MDPAUTEUR, $ROLEAUTEUR)
    {
        $this->IDAUTEUR     = $IDAUTEUR;
        $this->NOMAUTEUR    = $NOMAUTEUR;
        $this->PRENOMAUTEUR = $PRENOMAUTEUR;
        $this->EMAILAUTEUR  = $EMAILAUTEUR;
        $this->MDPAUTEUR    = $MDPAUTEUR;
        $this->ROLEAUTEUR[] = $ROLEAUTEUR;
    }

    /**
     * @return mixed
     */
    public function getIDAUTEUR()
    {
        return $this->IDAUTEUR;
    }

    /**
     * @return mixed
     */
    public function getNOMAUTEUR()
    {
        return $this->NOMAUTEUR;
    }

    /**
     * @return mixed
     */
    public function getPRENOMAUTEUR()
    {
        return $this->PRENOMAUTEUR;
    }

    /**
     * Returns the roles granted to the user.
     *
     * <code>
     * public function getRoles()
     * {
     *     return array('ROLE_USER');
     * }
     * </code>
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return (Role|string)[] The user roles
     */
    public function getRoles()
    {
        return $this->ROLEAUTEUR;
    }

    /**
     * Returns the password used to authenticate the user.
     *
     * This should be the encoded password. On authentication, a plain-text
     * password will be salted, encoded, and then compared to this value.
     *
     * @return string The password
     */
    public function getPassword()
    {
        return $this->MDPAUTEUR;
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername()
    {
        return $this->EMAILAUTEUR;
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials() {}
}