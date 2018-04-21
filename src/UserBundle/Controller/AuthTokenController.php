<?php

# src/UserBundle/Controller/AuthTokenController.php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest; // alias pour toutes les annotations
use UserBundle\Form\CredentialsType;
use UserBundle\Entity\AuthToken;
use UserBundle\Entity\Credentials;


use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\View\ViewHandler;
use FOS\RestBundle\View\View;

class AuthTokenController extends Controller
{
    /**
     * @Rest\View(statusCode=Response::HTTP_CREATED, serializerGroups={"auth-token"})
     * @Rest\Get("/json/auth-tokens")
     */
    public function postAuthTokensAction(Request $request)
    {
        $credentials = new Credentials();
        $credentials->setLogin($_GET['login']);
        $credentials->setPassword($_GET['password']);

        /*$form = $this->createForm(CredentialsType::class, $credentials);

        $form->submit($request->request->all());

        if (!$form->isValid()) {
            return $form;
        }*/

        $em = $this->get('doctrine.orm.entity_manager');

        $user = $em->getRepository('UserBundle:User')
            ->findOneByUsername($credentials->getLogin());

        if (!$user) { // L'utilisateur n'existe pas
            //return $this->invalidCredentials();
            return  ['AUTH_STATUS' => 'False'];
        }

        $encoder = $this->get('security.password_encoder');
        $isPasswordValid = $encoder->isPasswordValid($user, $credentials->getPassword());

        if (!$isPasswordValid) { // Le mot de passe n'est pas correct
            //return $this->invalidCredentials();
            return  ['AUTH_STATUS' => 'False'];
        }

        $authToken = new AuthToken();
        $authToken->setValue(base64_encode(random_bytes(50)));
        $authToken->setCreatedAt(new \DateTime('now'));
        $authToken->setUser($user);

        $em->persist($authToken);
        $em->flush();


        $formatted = [
            'AUTH_STATUS' => 'True',
            'id' => $user->getId(),
            'token' => $authToken->getValue(),
            'identity' => $user->getFirstName()." ".$user->getLastName(),


        ];

        $view = View::create($formatted);
        $view->setFormat('json');

        return $view;

        //return $authToken->getId();
    }

    private function invalidCredentials()
    {
        return \FOS\RestBundle\View\View::create(['message' => 'Invalid credentials'], Response::HTTP_BAD_REQUEST);
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
     * @Rest\Delete("/json/auth-tokens/{id}")
     */
    public function removeAuthTokenAction(Request $request)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $authToken = $em->getRepository('UserBundle:AuthToken')
            ->find($request->get('id'));
        /* @var $authToken AuthToken */

        $connectedUser = $this->get('security.token_storage')->getToken()->getUser();

        if ($authToken && $authToken->getUser()->getId() === $connectedUser->getId()) {
            $em->remove($authToken);
            $em->flush();
        } else {
            throw new \Symfony\Component\HttpKernel\Exception\BadRequestHttpException();
        }
    }
}