<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

class ResetController extends Controller
{
    /**
     * @Route("/reset", name="_reset")
     * @Method({"GET", "POST"})
     */
    public function resetAction(Request $request)
    {
        $resetForm = $this->createForm('AppBundle\Form\UserResetType');
        $resetForm->handleRequest($request);

        if ($resetForm->isSubmitted() && $resetForm->isValid()) {
            $data = $resetForm->getData();
            $username = $data->getUsername();
            $em = $this->getDoctrine()->getManager();
            $users = $em->getRepository('AppBundle:User')->findBy(array('username' => $username));
            $user = $users[0];
            $plainPassword = $data->getPlainPassword();
            $user->setPlainPassword($plainPassword);
            $userManager = $this->container->get('fos_user.user_manager');
            $userManager->updateUser($user);
            return $this->redirectToRoute('_index');

        }

        return $this->render('user/reset.html.twig', array(
            'form' => $resetForm->createView(),
        ));
    }
}