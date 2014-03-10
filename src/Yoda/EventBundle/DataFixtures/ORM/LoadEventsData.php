<?php
namespace Acme\HelloBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Yoda\EventBundle\Entity\Event;

class LoadEventsData implements FixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $event1 = new Event();
        $event1->setName('Event 1');
        $event1->setDetails('This is the first Event ever');
        $event1->setImageName('foo.jpg');
        $event1->setLocation('Kharkiv, Urkaine');
        $event1->setTime(new \DateTime('-3 Days'));
        $manager->persist($event1);

        $event2 = new Event();
        $event2->setName('Event 2');
        $event2->setDetails('And this is the second Event');
        $event2->setImageName('bar.jpg');
        $event2->setLocation('Kiev, Ukraine');
        $event2->setTime(new \DateTime('+1 Month'));
        $manager->persist($event2);

        $manager->flush();
    }
}