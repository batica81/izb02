<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */
class User implements UserInterface
{
    /**
     * @var
     *
     * @Groups({"group2"})
     */
    private $salt;

    /**
     * @var
     *
     * @Groups({"group1"})
     */
    private $roles;

    /**
     * @var int
     * @Groups({"group1"})
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @Groups({"group1"})
     *
     * @ORM\Column(name="email", type="string", length=255, unique=true)
     */
    private $email;

    /**
     * @var string
     * @Groups({"group1"})
     *
     * @ORM\Column(name="firstName", type="string", length=255)
     */
    private $firstName;

    /**
     * @var string
     * @Groups({"group1"})
     *
     * @ORM\Column(name="lastName", type="string", length=255)
     */
    private $lastName;


    /**
     * @var string
     * @Groups({"group2"})
     *
     * @ORM\Column(name="password", type="string", length=255, nullable=false)
     */
    private $password;

    /**
     * @var string
     * @Groups({"group2"})
     *
     * @ORM\Column(name="hashed_password", type="string", length=255, nullable=false)
     */
    private $hashedPassword;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     *
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set hashedPassword
     *
     * @param string $hashedPassword
     *
     * @return User
     */
    public function setHashedPassword($hashedPassword)
    {
        $this->hashedPassword = $hashedPassword;

        return $this;
    }

    /**
     * Get hashedPassword
     *
     * @return string
     */
    public function getHashedPassword()
    {
        return $this->hashedPassword;
    }

    public function getRoles()
    {
        return ['ROLE_USER'];
//        return $this->roles;
    }

    public function getSalt()
    {

        return $this->salt;
    }

    public function getUsername()
    {
        return $this->email;
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

}

