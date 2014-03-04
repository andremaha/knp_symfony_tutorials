<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Debug\Debug;

$loader = require_once __DIR__.'/app/bootstrap.php.cache';
Debug::enable();

require_once __DIR__.'/app/AppKernel.php';

$kernel = new AppKernel('dev', true);
$kernel->loadClassCache();
$request = Request::createFromGlobals();
$kernel->boot();

$container = $kernel->getContainer();
$container->enterScope('request');
$container->set('request', $request);

use Yoda\EventBundle\Entity\Event;

$event = new Event();
$event->setName('Big Concert');
$event->setDetails('This is the best concert ever');
$event->setLocation('Cologne, Germany');
$event->setTime(new \DateTime('+ 1 month'));
$event->setImageName('foo.jpg');

$em = $container->get('doctrine')->getManager();
$em->persist($event);
$em->flush();
