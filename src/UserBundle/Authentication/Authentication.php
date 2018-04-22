<?php
namespace UserBundle\Authentication;

use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Router;

// ROLE: Redirection selon le role de l'utilisateur à sa connexion
class Authentication implements AuthenticationSuccessHandlerInterface
{

    protected $router;
    protected $security;

    public function __construct(Router $router, AuthorizationCheckerInterface $security)
    {
        $this->router = $router;
        $this->security = $security;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        if ($this->security->isGranted('ROLE_ADMIN'))
        {
            // redirect the user to where they were before the login process begun.
            $response = new RedirectResponse($this->router->generate('index_super_admin'));
        }
        elseif ($this->security->isGranted('ROLE_COMPTABLE'))
        {
            $response = new RedirectResponse($this->router->generate('index_admin'));

        }
        elseif ($this->security->isGranted('ROLE_USER') OR $this->security->isGranted('ROLE_VISITEUR'))
        {
            // redirect the user to where they were before the login process begun.
            $response = new RedirectResponse($this->router->generate('fichefrais_index'));
        }


        return $response;
    }

}