<?php

namespace AppBundle\Doctrine;

use AppBundle\Entity\Password;
use Doctrine\ORM\Mapping as ORM;

class PasswordListener
{
    private $encodingMethod = "AES-128-CBC";

    public function getSubscribedEvents()
    {
        return ['prePersist', 'preUpdate', 'postLoad'];
    }

    /** @ORM\PrePersist */
    public function prePersist(Password $password)
    {
        if (!$password instanceof Password) {
            return;
        }

        $this->encodePassword($password);
    }

    /** @ORM\PreUpdate */
    public function preUpdate(Password $password)
    {
        if (!$password instanceof Password) {
            return;
        }

        $this->encodePassword($password);
    }

    /** @ORM\PostLoad */
    public function postLoad(Password $password)
    {
        if (!$password instanceof Password) {
            return;
        }

        $this->decodePassword($password);
    }

    /**
     * @param Password $entity
     */
    private function encodePassword(Password $entity)
    {
        if (!$entity->getPassword()) {
            return;
        }

        $plainPassword = $entity->getPassword();
        $plainLogin = $entity->getLogin();

        $method = $this->encodingMethod;
        $key = "key";
        $iv = "INITIALIZATIONVE";
        $encodedPassword = openssl_encrypt($plainPassword, $method, $key, $options = 0, $iv);
        $encodedLogin = openssl_encrypt($plainLogin, $method, $key, $options = 0, $iv);

        $entity->setPassword($encodedPassword);
        $entity->setLogin($encodedLogin);

    }

    /**
     * @param Password $entity
     */
    private function decodePassword(Password $entity)
    {
        if (!$entity->getPassword()) {
            return;
        }

        $encodedPassword = $entity->getPassword();
        $encodedLogin = $entity->getLogin();

        $method = $this->encodingMethod;
        $key = "key";
        $iv = "INITIALIZATIONVE";
        $plainPassword = openssl_decrypt($encodedPassword, $method, $key, $options = 0, $iv);
        $plainLogin = openssl_decrypt($encodedLogin, $method, $key, $options = 0, $iv);

        if($plainPassword) {
            $entity->setPassword($plainPassword);
        }

        if($plainLogin) {
            $entity->setLogin($plainLogin);
        }
    }

}

//        $em = $args->getEntityManager();
//        $meta = $em->getClassMetadata(get_class($password));
//        $em->getUnitOfWork()->recomputeSingleEntityChangeSet($meta, $password);