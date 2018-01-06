<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Password;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

class PasswordController extends Controller
{

    /**
     * @Route("/", name="_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $em = $this->getDoctrine()->getManager();
        $userId = $this->getUser()->getId();

        $passwords = $em->getRepository('AppBundle:Password')->findBy(array('userId' => $userId));

        return $this->render('password/index.html.twig', array(
            'passwords' => $passwords,
        ));
    }

    /**
     * @Route("/new", name="_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $password = new Password();
        $form = $this->createForm('AppBundle\Form\PasswordType', $password);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $userId = $this->getUser()->getId();
            $password->setUserId($userId);

            $em = $this->getDoctrine()->getManager();
            $em->persist($password);
            $em->flush();

            return $this->redirectToRoute('_index');
        }

        return $this->render('password/new.html.twig', array(
            'password' => $password,
            'form' => $form->createView()
        ));
    }


    /**
     * @Route("/{id}/password_edit", name="password_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Password $password)
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $userId = $this->getUser()->getId();
        $ownerId = $password->getUserId();
        if($userId != $ownerId){
            return $this->redirectToRoute('_index');
        }

        $editForm = $this->createForm('AppBundle\Form\PasswordType', $password);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('_index');
        }

        return $this->render('password/edit.html.twig', array(
            'password' => $password,
            'form' => $editForm->createView(),
        ));
    }

    /**
     * @Route("/{id}/delete", name="_delete")
     * @Method({"GET"})
     */
    public function deleteAction($id)
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $em = $this->getDoctrine()->getManager();
        $password = $em->getRepository('AppBundle:Password')->find($id);

        $userId = $this->getUser()->getId();
        $ownerId = $password->getUserId();
        if($userId != $ownerId){
            return $this->redirectToRoute('_index');
        }

        $em->remove($password);
        $em->flush();

        return $this->redirectToRoute('_index');
    }
}

//$user = $this->container->get('security.context')->getToken()->getUser();
//$user->getId();

///**
// * Password controller.
// *
// * @Route("{userId}")
// */


//return $this->redirectToRoute('_show', array('id' => $password->getId()));

///**
// * Creates a form to delete a password entity.
// *
// * @param Password $password The password entity
// *
// * @return \Symfony\Component\Form\Form The form
// */
//private function createDeleteForm(Password $password)
//{
//    return $this->createFormBuilder()
//        ->setAction($this->generateUrl('_delete', array('id' => $password->getId())))
//        ->setMethod('DELETE')
//        ->getForm()
//        ;
//}

///**
// * @Route("/{id}", name="_show")
// * @Method("GET")
// */
//public function showAction(Password $password)
//{
//    return $this->render('password/show.html.twig', array(
//        'password' => $password,
//    ));
//}
