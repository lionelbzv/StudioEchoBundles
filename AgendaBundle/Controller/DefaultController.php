<?php

namespace StudioEchoBundles\AgendaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('StudioEchoBundlesAgendaBundle:Default:index.html.twig', array('name' => $name));
    }
}