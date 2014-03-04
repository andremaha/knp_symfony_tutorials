<?php

namespace Yoda\EventBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($first_name, $last_name)
    {
        return $this->render('EventBundle:Default:index.html.twig', array(
            'name' => $first_name . ' ' . $last_name
        ));
    }
}
