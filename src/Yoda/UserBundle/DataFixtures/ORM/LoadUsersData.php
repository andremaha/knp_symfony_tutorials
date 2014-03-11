<?php
namespace Acme\HelloBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Yoda\UserBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

class LoadUsersData implements FixtureInterface, ContainerAwareInterface
{

    private $container;

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername('user');
        $user->setPassword($this->encodePassword($user, 'userpass'));
        $user->setEmail('user@example.com');
        $manager->persist($user);

        $admin = new User();
        $admin->setUsername('admin');
        $admin->setPassword($this->encodePassword($admin, 'adminpass'));
        $admin->setEmail('admin@example.com');
        $admin->setRoles(array('ROLE_ADMIN'));
        $manager->persist($admin);

        $inactive = new User();
        $inactive->setUsername('inactive');
        $inactive->setPassword($this->encodePassword($inactive, 'inactivepass'));
        $inactive->setEmail('inactive@example.com');
        $inactive->setIsActive(false);
        $manager->persist($inactive);

        $manager->flush();
    }

    private function encodePassword($user, $plainPassword)
    {
        $encoder = $this->container->get('security.encoder_factory')
            ->getEncoder($user);


        return $encoder->encodePassword($plainPassword, $user->getSalt());
    }

    /**
     * Sets the Container.
     *
     * @param ContainerInterface|null $container A ContainerInterface instance or null
     *
     * @api
     */public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
}