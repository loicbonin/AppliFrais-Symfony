<?php

namespace FraisBundle\Controller;

use FraisBundle\Entity\ForfaitFrais;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Forfaitfrai controller.
 *
 */
class ForfaitFraisController extends Controller
{
    /**
     * Lists all forfaitFrai entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $forfaitFrais = $em->getRepository('FraisBundle:ForfaitFrais')->findAll();

        return $this->render('forfaitfrais/index.html.twig', array(
            'forfaitFrais' => $forfaitFrais,
        ));
    }

    /**
     * Creates a new forfaitFrai entity.
     *
     */
    public function newAction(Request $request)
    {
        
        $user = $this->getUser();
        $ficheFraisId = $request->attributes->get('ficheFraisId');
        $em = $this->getDoctrine()->getManager();
        $ficheFrais = $em->getRepository('FraisBundle:FicheFrais')->find($ficheFraisId);
        $forfaitFrai = new Forfaitfrais();
        $form = $this->createForm('FraisBundle\Form\ForfaitFraisType', $forfaitFrai);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //$forfaitFrai->upload();
            $forfaitFrai->setFicheFrais($ficheFrais);
            $em->persist($forfaitFrai);
            $em->flush();
            return $this->redirectToRoute('fichefrais_index');
        }
        return $this->render('forfaitfrais/new.html.twig', array(
            'forfaitFrai' => $forfaitFrai,
            'form' => $form->createView(),
            'user' => $user,
        ));

    }

    /**
     * Finds and displays a forfaitFrai entity.
     *
     */
    public function showAction(ForfaitFrais $forfaitFrai)
    {
        $deleteForm = $this->createDeleteForm($forfaitFrai);

        return $this->render('forfaitfrais/show.html.twig', array(
            'forfaitFrai' => $forfaitFrai,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to delete a forfaitFrai entity.
     *
     * @param ForfaitFrais $forfaitFrai The forfaitFrai entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ForfaitFrais $forfaitFrai)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('forfaitfrais_delete', array('id' => $forfaitFrai->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Displays a form to edit an existing forfaitFrai entity.
     *
     */
    public function editAction(Request $request, ForfaitFrais $forfaitFrai)
    {
        $deleteForm = $this->createDeleteForm($forfaitFrai);
        $editForm = $this->createForm('FraisBundle\Form\ForfaitFraisType', $forfaitFrai);
        $editForm->handleRequest($request);
        if ($editForm->isSubmitted() && $editForm->isValid())
        {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('forfaitfrais_edit', array('id' => $forfaitFrai->getId()));
        }

        return $this->render('forfaitfrais/edit.html.twig', array(
            'forfaitFrai' => $forfaitFrai,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Modifier l'état d'un forfait frais pour le comptable
     *
     */
    public function editComptableAction(Request $request, ForfaitFrais $forfaitFrais)
    {
        $form = $this->createForm('FraisBundle\Form\ForfaitFraisComptableType', $forfaitFrais);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('forfaitfrais_edit_comptable', array('id' => $forfaitFrais->getId()));
        }

        return $this->render('forfaitfrais/etatEdit.html.twig', array(
            'forfaitFrais' => $forfaitFrais,
            'form' => $form->createView(),
        ));
    }

    /**
     * Deletes a forfaitFrai entity.
     *
     */
    public function deleteAction(Request $request, ForfaitFrais $forfaitFrai)
    {
        $form = $this->createDeleteForm($forfaitFrai);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->remove($forfaitFrai);
            $em->flush();
        }
        return $this->redirectToRoute('forfaitfrais_index');
    }
}
