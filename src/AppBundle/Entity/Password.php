<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * Password
 * @ORM\Table(name="password")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PasswordRepository")
 * @ORM\Entity @ORM\EntityListeners({"AppBundle\Listeners\Doctrine\PasswordListener"})
 */
class Password
{

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="userId", type="integer")
     */
    private $userId;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="login", type="string", length=255)
     */
    private $login;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="iv", type="string", length=255)
     */
    private $IV;

    /**
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param integer $userId
     * @return Password
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * @return integer 
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param string $name
     * @return Password
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $login
     * @return Password
     */
    public function setLogin($login)
    {
        $this->login = $login;

        return $this;
    }

    /**
     * @return string 
     */
    public function getLogin()
    {

        return $this->login;
    }

    /**
     * @param string $password
     * @return Password
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return string 
     */
    public function getPassword()
    {

        return $this->password;
    }


    /**
     * @param string $IV
     * @return Password
     */
    public function setIV($IV)
    {
        $this->IV = $IV;

        return $this;
    }

    /**
     * @return integer
     */
    public function getIV()
    {
        return $this->IV;
    }


}
