<?php

namespace Telma\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('TelmaUserBundle:Default:index.html.twig');
    }
}
