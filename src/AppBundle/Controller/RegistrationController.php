<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use FOS\UserBundle\Controller\RegistrationController as BaseController;

class RegistrationController extends BaseController
{

    public function confirmedAction()
    {
        $response = new RedirectResponse($this->container->get('router')->generate('_index'));
        return $response;
    }
}
