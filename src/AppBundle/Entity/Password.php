<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * Password
 *
 * @ORM\Table(name="password")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PasswordRepository")
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set userId
     *
     * @param integer $userId
     * @return Password
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return integer 
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Password
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set login
     *
     * @param string $login
     * @return Password
     */
    public function setLogin($login)
    {
        $this->login = $login;

        return $this;
    }

    /**
     * Get login
     *
     * @return string 
     */
    public function getLogin()
    {
//        $encoded = $this->login;
//        $method = "AES-128-CBC";
//        $key = "key";
//        $iv = "INITIALIZATIONVE";
//        $plainLogin = openssl_decrypt($encoded ,$method , $key, $options=0, $iv);
//
//        return $plainLogin;

        return $this->login;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return Password
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
//        $encoded = $this->password;
//        $method = "AES-128-CBC";
//        $key = "key";
//        $iv = "INITIALIZATIONVE";
//        $plainPassword = openssl_decrypt($encoded ,$method , $key, $options=0, $iv);
//
//        return $plainPassword;

        return $this->password;
    }

}
