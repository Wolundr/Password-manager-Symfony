<?php

namespace AppBundle\Doctrine;

use AppBundle\Entity\Password;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;

class HashDataListener implements EventSubscriber
{
//    private $encoderFactory;
//
//    public function __construct(EncoderFactory $encoderFactory)
//    {
//        $this->encoderFactory = $encoderFactory;
//    }

    public function postLoad(LifecycleEventArgs $args){
        $entity = $args->getEntity();

        if (!$entity instanceof Password) {
            return;
        }

//        $this->decodePassword($entity);
    }


    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        if (!$entity instanceof Password) {
            return;
        }

        $this->encodePassword($entity);
    }

    public function preUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        if (!$entity instanceof Password) {
            return;
        }
        $this->encodePassword($entity);
        $em = $args->getEntityManager();
        $meta = $em->getClassMetadata(get_class($entity));
        $em->getUnitOfWork()->recomputeSingleEntityChangeSet($meta, $entity);
    }

    public function getSubscribedEvents()
    {
        return ['prePersist', 'preUpdate'];
    }

    /**
     * @param Password $entity
     */
    private function encodePassword(Password $entity)
    {
        if (!$entity->getPassword()) {
            return;
        }

//        $encoder = $this->encoderFactory->getEncoder($entity);

        $plainPassword = $entity->getPassword();
        $plainLogin = $entity->getLogin();
        $method = "AES-128-CBC";
        $key = "key";
        $iv = "INITIALIZATIONVE";
        $encodedPassword = openssl_encrypt($plainPassword ,$method , $key, $options=0, $iv);
        $encodedLogin = openssl_encrypt($plainLogin ,$method , $key, $options=0, $iv);
//        $salt = $entity->getSalt();
//        $encoded = hash('sha256', $salt . $plainPassword);
        $entity->setPassword($encodedPassword);
        $entity->setLogin($encodedLogin);

//        $encoded = $encoder->encodePassword($plainPassword, $salt);
//        $encoded = $encoder->encodePassword($encoded, $salt);

//        $encoded = password_hash($plainPassword, PASSWORD_BCRYPT, array('cost' => 13));

//        $entity->setPassword(password_hash($user->getPassword(), PASSWORD_BCRYPT, array('cost' => 13)));

//        $encoderFactory = $this->get('security.encoder_factory');
//        $encoder = $encoderFactory->getEncoder($user);
//
//        $salt = 'salt'; // this should be different for every user
//        $password = $encoder->encodePassword('password', $salt);
//
//        $user->setSalt($salt);
//        $user->setPassword($password);
//
//        $plainPassword = $entity->getPassword();
//        $encoded = "haseleczko";

    }

    private function decodePassword(Password $entity)
    {
        if ((!$entity->getPassword())||(!$entity->getLogin())) {
            return;
        }

        $encodedPassword = $entity->getPassword();
        $encodedLogin = $entity->getLogin();
        $method = "AES-128-CBC";
        $key = "key";
        $iv = "INITIALIZATIONVE";
        $plainPassword = openssl_decrypt($encodedPassword ,$method , $key, $options=0, $iv);
        $plainLogin = openssl_decrypt($encodedLogin ,$method , $key, $options=0, $iv);

        $entity->setPassword($plainPassword);
        $entity->setLogin($plainLogin);
    }
}