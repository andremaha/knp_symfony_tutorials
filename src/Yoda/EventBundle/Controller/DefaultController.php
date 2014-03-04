<?php

namespace Yoda\EventBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name, $count)
    {
        $em = $this->getDoctrine()->getManager();

        $repo = $em->getRepository('EventBundle:Event');

        $event = $repo->findOneBy(array(
            'name' => 'Big Concert'
        ));

        return $this->render('EventBundle:Default:index.html.twig', array(
            'event' => $event
        ));
    }
}
