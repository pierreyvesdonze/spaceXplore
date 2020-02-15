<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * La classe utilisée par le module de securité DOIT implémenter UserInterface
 * Ce qui nous oblige a implémenter les methodes contenue dans UserInterface
 * Ces methodes sont celle que le module de securité va appeler
 * 
 * @ORM\Entity
 * @UniqueEntity("email", message="Cet email est déjà utilisé")
 */
class AppUser implements UserInterface
{

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\Length(max=100)
     * @Assert\NotBlank
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\Length(max=100)
     * @Assert\NotBlank
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=180)
     * @Assert\Length(max=180)
     * @Assert\NotBlank
     */
    private $email;

    /**
     * Contiendra le mot de passe hashé
     * Donc on ne met pas de contraintes de validation ici
     * on preferera mettre des contrainte dans le formulaire d'enregistrement d'un nouvel utilisateur pour verifier que le mot de passe non hashé soit assez grand, contienne des chiffre, des majusculles ...
     * 
     * @ORM\Column(type="string")
     */
    private $password;


   /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Role")
     */
    private $roles;

    public function __construct()
    {
        $this->roles = new ArrayCollection();
    }

    /**
     * Get the value of email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get the value of firstName
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set the value of firstName
     *
     * @return  self
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get the value of lastName
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set the value of lastName
     *
     * @return  self
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

      /**
     * Get the value of roles
     */
    public function getRolesCollection()
    {
        return $this->roles;
    }
    /**
     * Get the value of roles
     */
    public function getRoles()
    {
        $roleCodes = array();

        foreach($this->roles as $role) {
            $roleCodes[] = $role->getCode();
        }
        // symfo voudrai recevoir un truc du genre ['ROLE_USER', ROLE_TRUC ....]
        return $roleCodes;
    }

    public function setRoles(array $roles) {

        $this->roles = $roles;
    }

    public function getUsername()
    {
        return $this->email;
    }

    // bcrypt n'utilise pas de sel
    public function getSalt()
    {
    }

    // Aucune donnée sensible dans notre objet User donc on laisse vide
    public function eraseCredentials()
    {
    }
}
