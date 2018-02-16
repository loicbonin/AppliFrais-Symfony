<?php

namespace FraisBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('FraisBundle:Default:index.html.twig');
    }
}
