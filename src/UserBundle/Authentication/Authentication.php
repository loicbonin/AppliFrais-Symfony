<?php
namespace UserBundle\Authentication;

use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Router;

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
            $response = new RedirectResponse($this->router->generate('index_admin'));

        }
        elseif ($this->security->isGranted('ROLE_USER'))
        {
            // redirect the user to where they were before the login process begun.
            $response = new RedirectResponse($this->router->generate('fichefrais_index'));
        }

        return $response;
    }

}