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
        $password = new Password();
        $form = $this->createForm('AppBundle\Form\PasswordType', $password);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $userId = $this->getUser()->getId();
            $password->setUserId($userId);

            $in = utf8_encode(random_bytes(16));
            $iv = strlen($in) > 16 ? substr($in,0,16) : $in;
            $password->setIV($iv);

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
     * @Route("/password_edit={id}", name="password_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Password $password)
    {
        $userId = $this->getUser()->getId();
        $ownerId = $password->getUserId();
        if($userId != $ownerId){
            return $this->redirectToRoute('_index');
        }

        $editForm = $this->createForm('AppBundle\Form\PasswordType', $password);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $in = utf8_encode(random_bytes(16));
            $iv = strlen($in) > 16 ? substr($in,0,16) : $in;
            $password->setIV($iv);

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('_index');
        }

        return $this->render('password/edit.html.twig', array(
            'password' => $password,
            'form' => $editForm->createView(),
        ));
    }

    /**
     * @Route("/delete={id}", name="_delete")
     * @Method({"GET"})
     */
    public function deleteAction($id)
    {
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
