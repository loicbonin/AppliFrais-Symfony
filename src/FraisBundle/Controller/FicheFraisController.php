<?php
namespace FraisBundle\Controller;

use FraisBundle\Entity\FicheFrais;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\View\ViewHandler;
use FOS\RestBundle\View\View; // Utilisation de la vue de FOSRestBundle

/**
 * Fichefrais controller.
 *
 */
class FicheFraisController extends Controller
{
    /**
     * Lists all ficheFrai entities.
     * @Security("has_role('ROLE_USER', 'ROLE_SUPER_ADMIN')")
     */
    public function indexAction(Request $request)
    {
        $onefichefrais = null;
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $ficheFrais = $em->getRepository('FraisBundle:FicheFrais')->getFraisByDate($user);
        $allexceptlast = $em->getRepository('FraisBundle:FicheFrais')->AllExceptLast($user);
        $forfaitHorsFrais = $em->getRepository('FraisBundle:ForfaitHorsFrais')->findAll();
        $forfaitFrais = $em->getRepository('FraisBundle:ForfaitFrais')->findAll();

        $lastfichefrais = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('FraisBundle:FicheFrais')
            ->getLastEntity($user)
        ;

        if (!null == $lastfichefrais)
        {
            foreach($lastfichefrais as $onefichefrais)
            {
                $monthyear = $onefichefrais->getMonthyear();
                if (date('M - Y') != $monthyear && date('d') < 11)
                {
                    $onefichefrais = new FicheFrais();
                    $onefichefrais->setMonthyear(date('M - Y'));
                    $onefichefrais->setUser($user);
                    $em->persist($onefichefrais);
                    $em->flush();
                }
                if (date('M - Y', strtotime('+1 month')) != $monthyear && date('d') > 10){
                    $onefichefrais = new FicheFrais();
                    $onefichefrais->setMonthyear(date('M - Y', strtotime('+1 month')));
                    $onefichefrais->setUser($user);
                    $em->persist($onefichefrais);
                    $em->flush();
                }
            }
        }
        elseif (null == $lastfichefrais)
        {
            foreach($lastfichefrais as $onefichefrais)
            {
                    $onefichefrais = new FicheFrais();
                    $onefichefrais->setMonthyear(date('M - Y'));
                    $onefichefrais->setUser($user);
                    $em->persist($onefichefrais);
                    $em->flush();
            }
        }

        return $this->render('fichefrais/index.html.twig', array(
            'ficheFrais' => $ficheFrais,
            'forfaitHorsFrais' => $forfaitHorsFrais,
            'forfaitFrais' => $forfaitFrais,
            'onefichefrais' => $onefichefrais,
            'allexceptlast' => $allexceptlast,
            'lastfichefrais' => $lastfichefrais,
            'user' => $user,
        ));
    }

    /**
     * @Security("has_role('ROLE_COMPTABLE', 'ROLE_SUPER_ADMIN')")
     *
     */
    public function indexAdminAction(Request $request)
    {

        $query = $this->getDoctrine()->getEntityManager()
            ->createQuery(
                'SELECT u FROM UserBundle:User u WHERE u.roles LIKE :role'
            )->setParameter('role', '%"ROLE_VISITEUR"%');

        $users = $query->getResult();
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $allFicheFrais = $em->getRepository('FraisBundle:FicheFrais')->findAll();
        $thisMonthfichefrais = $em->getRepository('FraisBundle:FicheFrais')->findByMonthyear(date('M - Y'));

        /*foreach ($allFicheFrais as $fiche){
            $NbFraisValide = $fiche->getNbFraisValide();
            $NbFrais = $fiche->getNbFrais();
        }*/

        return $this->render('fichefrais/indexAdmin.html.twig', array(
            'allFicheFrais' => $allFicheFrais,
            'thisMonthfichefrais' => $thisMonthfichefrais,
            'user' => $user,
            'users' => $users,
        ));
    }

    /**
     * @Security("has_role('ROLE_COMPTABLE', 'ROLE_SUPER_ADMIN')")
     *
     */
    public function ficheParUserAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $visiteurId = $request->get('id');
        $visiteur = $em->getRepository('UserBundle:User')->find($visiteurId);
        $user = $this->getUser();
        $listSuivieValide = [];

        $listFicheFrais = $em->getRepository('FraisBundle:FicheFrais')->getFraisByDate($visiteur);
        /*return $this->redirectToRoute('admin_index', array(
            'ficheFraisId' => $ficheFrais->getId()));*/

        foreach ($listFicheFrais as $fiche){
            $NbFraisValide = $fiche->getNbFraisValide();
            $NbFrais = $fiche->getNbFrais();
            if($NbFraisValide == $NbFrais){
               $listSuivieValide[] = $fiche->getId();
               if($fiche->getPayement() != "Remboursé" or $fiche->getPayement() != "En cours de paiement" ) {
                   $fiche->setDerniereEdition(new \DateTime());
                   $em->persist($fiche);
                   $em->flush();
               }
            }
        }

        return $this->render('fichefrais/ficheParUser.html.twig', array(
            'allFicheFrais' => $listFicheFrais,
            'listSuivieValide' => $listSuivieValide,
            'user' => $user,
            'visiteur' => $visiteur,
        ));
    }

    /**
     * @Security("has_role('ROLE_ADMIN', 'ROLE_SUPER_ADMIN')")
     *
     */
    public function indexSuperAdminAction(Request $request)
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $listUsers = $em->getRepository('UserBundle:User')->findAll();

        return $this->render('fichefrais/indexSuperAdmin.html.twig', array(
            'listUsers' => $listUsers,
            'user' => $user,
        ));
    }

    /**
     * Creation d'une nouvelle fiche frais.
     *
     */
    public function newAction(Request $request)
    {
        $user = $this->getUser();
        /*if (null !== $user->getFicheFrais())
           {
                $ficheFrais = $user->getFicheFrais();
                dump($ficheFrais);
                if (date('M') != $ficheFrais->getMonth())
                {
                    # code...
                }
           } */

        $userId = $user->getId();
        $em = $this->getDoctrine()->getManager();
        $ficheFrais = new Fichefrais();
        $form = $this->createForm('FraisBundle\Form\FicheFraisType', $ficheFrais);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $ficheFrais->setUser($user);
            $em->persist($ficheFrais);
            $em->flush();
            return $this->redirectToRoute('fichefrais_show', array('id' => $ficheFrais->getId()));
        }
        return $this->render('fichefrais/new.html.twig', array(
            'ficheFrai' => $ficheFrais,
            'form' => $form->createView(),
        ));
    }
    /**
     * Finds and displays a ficheFrai entity.
     *
     */
    public function showAction(FicheFrais $ficheFrai)
    {
        $deleteForm = $this->createDeleteForm($ficheFrai);
        return $this->render('fichefrais/show.html.twig', array(
            'ficheFrai' => $ficheFrai,
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Modifier une fiche frais existante
     *
     */
    public function editAction(Request $request, FicheFrais $ficheFrais) //Modifier en addhorsfrait
    {
        return $this->redirectToRoute('forfaithorsfrais_new', array(
            'ficheFraisId' => $ficheFrais->getId()));
    }

    /**
     * Modifier l'état de la fiche frais pour le comptable
     *
     */
    public function etatAction(Request $request, FicheFrais $ficheFrais)
    {
        $form = $this->createForm('FraisBundle\Form\FicheFraisComptableType', $ficheFrais);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('fichefrais_etat', array('id' => $ficheFrais->getId()));
        }

        return $this->render('fichefrais/etatEdit.html.twig', array(
            'ficheFrais' => $ficheFrais,
            'form' => $form->createView(),
        ));
    }

    public function addForfaitFraisAction(Request $request, FicheFrais $ficheFrais) //Modifier en addhorsfrait
    {
        return $this->redirectToRoute('forfaitfrais_new', array(
            'ficheFraisId' => $ficheFrais->getId()));
    }

    /**
     * Deletes a ficheFrai entity.
     *
     */
    public function deleteAction(Request $request, FicheFrais $ficheFrai)
    {
        $form = $this->createDeleteForm($ficheFrai);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->remove($ficheFrai);
            $em->flush();
        }
        return $this->redirectToRoute('fichefrais_index');
    }
    /**
     * Creates a form to delete a ficheFrai entity.
     *
     * @param FicheFrais $ficheFrai The ficheFrai entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(FicheFrais $ficheFrai)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('fichefrais_delete', array('id' => $ficheFrai->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }

    /**
     * Download a pdf.
     *
     */
    public function pdfAction(Request $request)
    {
        $ficheFrais = $this->get('doctrine.orm.entity_manager')
            ->getRepository('FraisBundle:FicheFrais')
            ->find($request->get('id'));

        $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
        $fontDirs = $defaultConfig['fontDir'];
        $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
        $fontData = $defaultFontConfig['fontdata'];
        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'fontDir' => array_merge($fontDirs, [
                __DIR__ . '/../fonts',
            ]),
            'fontdata' => $fontData + [
                    'freeMono' => [
                        'R' => 'FreeMono.ttf',
                        'M' => 'FreeMonoOblique.ttf',
                        'B' => 'FreeMonoBold.ttf',
                    ],
                ],
            'default_font' => 'freeMono',
            'img_dpi' => 150,
            'dpi' => 150,
            'margin-footer' => 0,
            'margin-bottom' => 0,
            'defaultfooterline' => 0,
            'showStats' => true,
        ]);
        $html =  $this->renderView('fichefrais/pdf.html.twig', array(
            'ficheFrais' => $ficheFrais,
        ));
        $mpdf->shrink_tables_to_fit = 1;
        $mpdf->WriteHTML($html);
        $mpdf->Output('GSB '.$ficheFrais->getMonthyear().'.pdf', \Mpdf\Output\Destination::DOWNLOAD);
    }

    // ajout pour api rest

    /**
     * @param Request $request
     * @Rest\View()
     * @Rest\Get("/json/fichefrais")
     */
    public function getFicheFraisAction(Request $request)
    {
        $ficheFraisId = $_GET['idFiche'];

        /*$ficheFrais = $this->get('doctrine.orm.entity_manager')
            ->getRepository('FraisBundle:FicheFrais')
            ->find($request->get('id'));*/



        $em = $this->getDoctrine()->getManager();

        $userId = $_GET['id'];
        $tokenValue = $_GET['token'];

        $user = $em->getRepository('UserBundle:User')->find($userId);
        $token = $em->getRepository('UserBundle:AuthToken')->find($tokenValue);

        $date = $token->getCreatedAt();
        $dateNow = date("Y-m-d H:i:s");
        $datetime1 = strtotime($date->format('Y-m-d H:i:s'));
        $datetime2 = strtotime($dateNow);

        $secs = $datetime2 - $datetime1;// == <seconds between the two times>
        $mins = $secs / 60;
        $formatted = [];

        if($mins > 15){

            $formatted[] = [
                'AUTH_STATUS' => "False",
            ];
            return new JsonResponse($formatted);
        }
        else {
            $ficheFrais = $this->get('doctrine.orm.entity_manager')
                ->getRepository('FraisBundle:FicheFrais')
                ->find($ficheFraisId);

            if (empty($ficheFrais)) {
                return new JsonResponse(['message' => 'fiche frais non trouvé'], Response::HTTP_NOT_FOUND);
            }

            $statusTemp = $ficheFrais->getEtat();
            if( $statusTemp == Null){
                $statusARenvoyer = 1;
            }
            elseif ($ficheFrais->getPayement() == "En cours de paiement"){
                $statusARenvoyer = 2;
            }
            elseif ($ficheFrais->getPayement() == "Remboursé"){
                $statusARenvoyer = 3;
            }
            else{
                $statusARenvoyer = 1;
            }

            $tabforfaitfrais = [];

            $forfaitfrais = $ficheFrais->getFrais();

            $forfaithorsfrais = $ficheFrais->getHorsFrais();

            foreach( $forfaitfrais as $forfait ){
                $tabforfaitfrais[] = [
                    'id' => $forfait->getId(),
                    'type' => 'Forfait',
                    'dateforfait' => $forfait->getDateDuFrais(),
                    'intitulé' => $forfait->getForfait()->getWording(),
                    'price' => ($forfait->getForfait()->getUnitPrice()*$forfait->getQuantity()),
                    'comment' => $forfait->getComment(),
                    'etat' => $forfait->getEtat()->getWording(),
                ];
            }

            foreach( $forfaithorsfrais as $forfait ){
                $tabforfaitfrais[] = [
                    'id' => $forfait->getId(),
                    'type' => 'Hors Forfait',
                    'dateforfait' => $forfait->getDateDuFrais(),
                    'intitulé' => $forfait->getWording(),
                    'price' => $forfait->getPrice(),
                    'comment' => $forfait->getComment(),
                    'etat' => $forfait->getEtat()->getWording(),
                ];
            }
            //return $ficheFrais;
            $formatted = [
                'AUTH_STATUS' => "True",
                'fiche' => [
                    'id' => $ficheFrais->getId(),
                    'status' => $statusARenvoyer,
                    //'title' => $ficheFrais->getTitle(),
                    'monthYear' => $ficheFrais->getMonthyear(),
                    'lignes' => $tabforfaitfrais,
                ]
            ];

            return new JsonResponse($formatted);
        }
    }

    /**
     * @param Request $request
     * @Rest\View()
     * @Rest\Get("/json/fichesfrais")
     */
    public function getFichesFraisAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $userId = $_GET['id'];
        $tokenValue = $_GET['token'];
        $tokenId = $_GET['token'];

        $user = $em->getRepository('UserBundle:User')->find($userId);
        //$token = $em->getRepository('UserBundle:AuthToken')->findOneByValue($tokenValue);
        $token = $em->getRepository('UserBundle:AuthToken')->find($tokenId);

        $date = $token->getCreatedAt();
        $dateNow = date("Y-m-d H:i:s");
        $datetime1 = strtotime($date->format('Y-m-d H:i:s'));
        $datetime2 = strtotime($dateNow);

        $secs = $datetime2 - $datetime1;// == <seconds between the two times>
        $mins = $secs / 60;

        if($mins > 15){
            $formatted = [];
            $formatted[] = [
                'AUTH_STATUS' => "False",
            ];
            return new JsonResponse($formatted);
        }
        else{
            $fiches = $this->get('doctrine.orm.entity_manager')->getRepository('FraisBundle:FicheFrais')->getFraisByDate($user);
            /* @var $fiches FicheFrais[] */


            $formatted = [];
            foreach ($fiches as $fiche) {
                $prixDesHorsForfait = 0;
                $prixDesFrais = 0;

                $fraisHorsForfait = $fiche->getHorsFrais();
                $fraisForfait = $fiche->getFrais();
                if($fraisHorsForfait != null && !empty($fraisHorsForfait) ) {
                    foreach ($fraisHorsForfait as $fhf) {
                        $prixfhf = $fhf->getPrice();
                        $prixDesHorsForfait = $prixDesHorsForfait + $prixfhf;
                    }
                }
                if ( $fraisForfait != null && !empty($fraisForfait)){
                    foreach ($fraisForfait as $ff){
                        $quantite = $ff->getQuantity();
                        $prixfraisforfait = $ff->getForfait()->getUnitPrice();
                        $prixFinal = $quantite*$prixfraisforfait;
                        $prixDesFrais = $prixDesFrais + $prixFinal;
                    }
                }

                $prixDeLaFiche = $prixDesFrais + $prixDesHorsForfait;

                $statusTemp = $fiche->getEtat();
                if( $statusTemp == Null){
                    $statusARenvoyer = 1;
                }
                elseif ($fiche->getPayement() == "En cours de paiement"){
                    $statusARenvoyer = 2;
                }
                elseif ($fiche->getPayement() == "Remboursé"){
                    $statusARenvoyer = 3;
                }
                else{
                    $statusARenvoyer = 1;
                }

                $formatted[] = [

                    'id' => $fiche->getId(),
                    'status' => $statusARenvoyer,
                    'monthYear' => $fiche->getMonthyear(),
                    'value' => $prixDeLaFiche,
                ];
            }
            return new JsonResponse(['AUTH_STATUS' => "True", 'fiches' => $formatted]);
        }


        // Récupération du view handler
        /*$viewHandler = $this->get('fos_rest.view_handler');
        // Création d'une vue FOSRestBundle
        $view = View::create($formatted);
        $view->setFormat('json');
        // Gestion de la réponse
        return $viewHandler->handle($view);*/

        /*$view = View::create($fiches);
        $view->setFormat('json');

        return $view;*/

        //return $fiches;
    }

    public function androidAppAction()
    {
        return $this->render('androidapp.html.twig');
    }

    public function miseEnPayementAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $visiteurId = $request->get('id');
        $ficheId = $request->get('fiche');
        $fiche = $em->getRepository('FraisBundle:FicheFrais')->find($ficheId);
        $fiche->setPayement("En cours de payement");
        $fiche->setDerniereEdition(new \DateTime());
        $em->persist($fiche);
        $em->flush();

        return $this->redirectToRoute('fiche_par_user', array('id' => $visiteurId));
    }
}
