<?php
namespace FraisBundle\Controller;
use FraisBundle\Entity\ForfaitHorsFrais;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use FraisBundle\Entity\FicheFrais;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
/**
 * Forfaithorsfrai controller.
 *
 */
class ForfaitHorsFraisController extends Controller
{
    /**
     * Lists all forfaitHorsFrai entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $forfaitHorsFrais = $em->getRepository('FraisBundle:ForfaitHorsFrais')->findAll();
        return $this->render('forfaithorsfrais/index.html.twig', array(
            'forfaitHorsFrais' => $forfaitHorsFrais,
        ));
    }
    /**
     * Creates a new forfaitHorsFrai entity.
     *
     */
    public function newAction(Request $request /*FicheFrais $ficheFrais*/)
    {   //$_GET[id];
        //$ficheFraisId = $ficheFrais->getId();
        $user = $this->getUser();
        $ficheFraisId = $request->attributes->get('ficheFraisId');
        $em = $this->getDoctrine()->getManager();
        $etat = $em->getRepository('FraisBundle:Etat')->find(1);

        $ficheFrais = $em->getRepository('FraisBundle:FicheFrais')->find($ficheFraisId);
        $forfaitHorsFrais = new Forfaithorsfrais();
        $form = $this->createForm('FraisBundle\Form\ForfaitHorsFraisType', $forfaitHorsFrais);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $forfaitHorsFrais->getPieceJointe();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $file->move(
                $this->getParameter('pieceJointes'),
                $fileName);
            $forfaitHorsFrais->setPieceJointe($fileName);

            //$forfaitHorsFrais->upload();
            $forfaitHorsFrais->setFicheFrais($ficheFrais);
            $forfaitHorsFrais->setEtat($etat);
            $em->persist($forfaitHorsFrais);
            $em->flush();
            return $this->redirectToRoute('fichefrais_index');
        }
        return $this->render('forfaithorsfrais/new.html.twig', array(
            'forfaitHorsFrai' => $forfaitHorsFrais,
            'form' => $form->createView(),
            'user' => $user,
        ));
    }
    /**
     * Finds and displays a forfaitHorsFrai entity.
     *
     */
    public function showAction(ForfaitHorsFrais $forfaitHorsFrai)
    {
        $deleteForm = $this->createDeleteForm($forfaitHorsFrai);
        return $this->render('forfaithorsfrais/show.html.twig', array(
            'forfaitHorsFrai' => $forfaitHorsFrai,
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Displays a form to edit an existing forfaitHorsFrai entity.
     *
     */
    public function editAction(Request $request, ForfaitHorsFrais $forfaitHorsFrai)
    {
        $forfaitHorsFrai->setPieceJointe(
            new File($this->getParameter('pieceJointes').'/'.$forfaitHorsFrai->getPieceJointe())
        );

        $actualFile = $forfaitHorsFrai->getPieceJointe();


        $deleteForm = $this->createDeleteForm($forfaitHorsFrai);
        $editForm = $this->createForm('FraisBundle\Form\ForfaitHorsFraisType', $forfaitHorsFrai);
        $editForm->handleRequest($request);
        if ($editForm->isSubmitted() && $editForm->isValid())
        {
            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $forfaitHorsFrai->getPieceJointe();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $file->move(
                $this->getParameter('pieceJointes'),
                $fileName);
            $forfaitHorsFrai->setPieceJointe($fileName);

            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('forfaithorsfrais_edit', array('id' => $forfaitHorsFrai->getId()));
        }
        return $this->render('forfaithorsfrais/edit.html.twig', array(
            'forfaitHorsFrai' => $forfaitHorsFrai,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Modifier l'état d'un forfait hors frais pour le comptable
     *
     */
    public function editComptableAction(Request $request, ForfaitHorsFrais $forfaitHorsFrais)
    {
        //$deleteForm = $this->createDeleteForm($forfaitHorsFrais);

        $actualFile = $forfaitHorsFrais->getPieceJointe();
        $forfaitHorsFrais->setPieceJointe(
            new File($this->getParameter('pieceJointes').'/'.$forfaitHorsFrais->getPieceJointe())
        );

        $form = $this->createForm('FraisBundle\Form\ForfaitHorsFraisComptableType', $forfaitHorsFrais);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {

            $forfaitHorsFrais->setPieceJointe($actualFile);

            $this->getDoctrine()->getManager()->flush();
            if($forfaitHorsFrais->getEtat()->getWording() == 'invalidée'){
                $forfaitHorsFrais->setWording("REFUSÉ: ".$forfaitHorsFrais->getWording());
            }
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('forfaithorsfrais_edit_comptable', array('id' => $forfaitHorsFrais->getId()));
        }

        return $this->render('forfaithorsfrais/etatEdit.html.twig', array(
            'forfaitHorsFrais' => $forfaitHorsFrais,
            'pj' => $actualFile,
            'form' => $form->createView(),
            //'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a forfaitHorsFrai entity.
     *
     */
    public function deleteAction(Request $request, ForfaitHorsFrais $forfaitHorsFrai)
    {

        $form = $this->createDeleteForm($forfaitHorsFrai);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->remove($forfaitHorsFrai);
            $em->flush();
            $this->addFlash(
                'notice',
                'Le frais à bien été supprimé!'
            );
            return $this->redirectToRoute('fichefrais_index');
        }
        return $this->redirectToRoute('fichefrais_index');
    }
    /**
     * Creates a form to delete a forfaitHorsFrai entity.
     *
     * @param ForfaitHorsFrais $forfaitHorsFrai The forfaitHorsFrai entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ForfaitHorsFrais $forfaitHorsFrai)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('forfaithorsfrais_delete', array('id' => $forfaitHorsFrai->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }
}
