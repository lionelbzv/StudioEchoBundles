<?php

namespace StudioEchoBundles\StudioEchoBundlesIvoryLuceneIndexationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('StudioEchoBundlesIvoryLuceneIndexationBundle:Default:index.html.twig', array('name' => $name));
    }
}
