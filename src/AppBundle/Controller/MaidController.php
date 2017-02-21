<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Maid;
use AppBundle\Entity\Timeslot;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Maid controller.
 *
 * @Route("back-office/maid")
 */
class MaidController extends Controller
{
    /**
     * Lists all maid entities
     *
     * @Route("/", name="back-office_maid_index")
     * @Method("GET") 
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $maids = $em->getRepository('AppBundle:Maid')->findAll();

        return $this->render('back-office/maid/index.html.twig', array(
            'maids' => $maids,
        ));
    }

    /**
     * Creates a new maid entity.
     *
     * @Route("/new", name="back-office_maid_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $maid = new Maid();
        $form = $this->createForm('AppBundle\Form\MaidType', $maid);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($maid);
            $em->flush();

            return $this->redirectToRoute('back-office_maid_show', array('id' => $maid->getId()));
        }

        return $this->render('back-office/maid/new.html.twig', array(
            'maid' => $maid,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a maid entity.
     *
     * @Route("/{id}", name="back-office_maid_show")
     * @Method("GET")
     */
    public function showAction(Maid $maid)
    {
        $deleteForm = $this->createDeleteForm($maid);
        $newTimeslot = new Timeslot();
        $createForm = $this->createForm('AppBundle\Form\TimeslotType', $newTimeslot);
        $timeslotToEdit = $maid->getTimeslots()[0];
        $editForm = $this->createForm('AppBundle\Form\TimeslotType', $timeslotToEdit);
        
        return $this->render('back-office/maid/show.html.twig', array(
            'maid' => $maid,
            'timeslots' => $maid->getTimeslots(),
            'delete_form' => $deleteForm->createView(),'createForm' => $createForm->createView(),
            'edit_form' => $editForm->createView(),
            'timeslot_to_edit' => $timeslotToEdit
        ));
    }

    /**
     * Displays a form to edit an existing maid entity.
     *
     * @Route("/{id}/edit", name="back-office_maid_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Maid $maid)
    {
        $deleteForm = $this->createDeleteForm($maid);
        $editForm = $this->createForm('AppBundle\Form\MaidType', $maid);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('back-office_maid_edit', array('id' => $maid->getId()));
        }

        return $this->render('back-office/maid/edit.html.twig', array(
            'maid' => $maid,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a maid entity.
     *
     * @Route("/{id}", name="back-office_maid_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Maid $maid)
    {
        $form = $this->createDeleteForm($maid);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($maid);
            $em->flush($maid);
        }

        return $this->redirectToRoute('back-office_maid_index');
    }


    /**
     * Creates a form to delete a maid entity.
     *
     * @param Maid $maid The maid entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Maid $maid)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('back-office_maid_delete', array('id' => $maid->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }

}