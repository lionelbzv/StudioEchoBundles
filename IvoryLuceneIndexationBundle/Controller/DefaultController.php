<?php

namespace StudioEchoBundles\IvoryLuceneIndexationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('StudioEchoBundlesIvoryLuceneIndexationBundle:Default:index.html.twig', array('name' => $name));
    }
}
