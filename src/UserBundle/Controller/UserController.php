<?php

namespace UserBundle\Controller;

use UserBundle\Entity\User;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use FOS\RestBundle\Controller\Annotations as Rest;
//use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\View\ViewHandler;
use FOS\RestBundle\View\View; // Utilisation de la vue de FOSRestBundle

/**
 * User controller.
 *
 */
class UserController extends Controller
{
    /**
     * Lists all user entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository('UserBundle:User')->findAll();

        return $this->render('user/index.html.twig', array(
            'users' => $users,
        ));
    }

    /**
     * Creates a new user entity.
     *
     */
    public function newAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm('UserBundle\Form\UserType', $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('user_show', array('id' => $user->getId()));
        }

        return $this->render('user/new.html.twig', array(
            'user' => $user,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a user entity.
     *
     */
    public function showAction(User $user)
    {
        $deleteForm = $this->createDeleteForm($user);

        return $this->render('user/show.html.twig', array(
            'user' => $user,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing user entity.
     *
     */
    public function editAction(Request $request, User $user)
    {
        $deleteForm = $this->createDeleteForm($user);
        if($this->container->get('security.authorization_checker')->isGranted('ROLE_ADMIN')){
            $editForm = $this->createForm('UserBundle\Form\UserAdminType', $user);
        }
        else{
            $editForm = $this->createForm('UserBundle\Form\UserType', $user);
        }
        $editForm->handleRequest($request);
        $actualRoles = $user->getRoles();
        $actualpassword = $user->getPassword();
        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $newRoles = $user->getRoles();
            if(empty($newRoles) && !empty($actualRoles)){
                $user->setRoles($actualRoles);
            }
            $user->setPassword($actualpassword);
            $this->getDoctrine()->getManager()->persist($user);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_edit', array('id' => $user->getId()));
        }

        return $this->render('user/edit.html.twig', array(
            'user' => $user,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a user entity.
     *
     */
    public function deleteAction(Request $request, User $user)
    {
        $form = $this->createDeleteForm($user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($user);
            $em->flush();
        }

        return $this->redirectToRoute('user_index');
    }

    /**
     * Creates a form to delete a user entity.
     *
     * @param User $user The user entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(User $user)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('user_delete', array('id' => $user->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    // ajout pour api rest

    /**
     * @param Request $request
     * @Rest\View()
     * @Rest\Get("/json/users")
     */
    public function getUsersAction(Request $request)
    {
        $users = $this->get('doctrine.orm.entity_manager')
            ->getRepository('UserBundle:User')
            ->findAll();
        /* @var $users User[] */

        //return $users;

        $formatted = [];
        foreach ($users as $user) {
            $formatted = [
                'id' => $user->getId(),
                'firstname' => $user->getFirstName(),
                'lastname' => $user->getLastName(),
                'email' => $user->getEmail(),
                'job' => $user->getJob(),
                'address' => $user->getAddress(),
                'zipCode' => $user->getZipCode(),
                'city' => $user->getCity(),
                'birthDate' => $user->getBirthDate(),
                'fuel' => $user->getFuel(),
                'fiscalPower' => $user->getFiscalPower(),
                'hiringDate' => $user->getHiringDate(),

            ];
        }
        $view = View::create($formatted);
        $view->setFormat('json');

        return $view;
        //return new JsonResponse($formatted);
    }

    /**
     * @param Request $request
     * @Rest\View()
     * @Rest\Get("/json/user")
     */
    public function getUserAction(Request $request)
    {
        $user = $this->getUser();
        /*$user = $this->get('doctrine.orm.entity_manager')
            ->getRepository('UserBundle:User')
            ->find($request->get('user_id'));*/
        /* @var $user User */

        if (empty($user)) {
            return new JsonResponse(['message' => 'User not found'], Response::HTTP_NOT_FOUND);
        }

        $formatted = [
            'id' => $user->getId(),
            'firstname' => $user->getFirstName(),
            'lastname' => $user->getLastName(),
            'email' => $user->getEmail(),
            'job' => $user->getJob(),
            'address' => $user->getAddress(),
            'zipCode' => $user->getZipCode(),
            'city' => $user->getCity(),
            'birthDate' => $user->getBirthDate(),
            'fuel' => $user->getFuel(),
            'fiscalPower' => $user->getFiscalPower(),
            'hiringDate' => $user->getHiringDate(),

        ];

        $view = View::create($formatted);
        $view->setFormat('json');

        return $view;
        //return new JsonResponse($formatted);

    }

    /**
     * @param Request $request
     * @Rest\View()
     * @Rest\Get("/json/oneuser/{id}")
     */
    public function getOneUserAction($id, Request $request)
    {

        $user = $this->get('doctrine.orm.entity_manager')
            ->getRepository('UserBundle:User')
            ->find($request->get($id));
        /* @var $user User */

        if (empty($user)) {
            return new JsonResponse(['message' => 'User not found'], Response::HTTP_NOT_FOUND);
        }

        $formatted = [
            'id' => $user->getId(),
            'firstname' => $user->getFirstName(),
            'lastname' => $user->getLastName(),
            'email' => $user->getEmail(),
            'job' => $user->getJob(),
            'address' => $user->getAddress(),
            'zipCode' => $user->getZipCode(),
            'city' => $user->getCity(),
            'birthDate' => $user->getBirthDate(),
            'fuel' => $user->getFuel(),
            'fiscalPower' => $user->getFiscalPower(),
            'hiringDate' => $user->getHiringDate(),

        ];

        $view = View::create($formatted);
        $view->setFormat('json');

        return $view;
        //return new JsonResponse($formatted);

    }
}
