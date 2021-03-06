<?php

namespace Yoda\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\User\UserInterface;
use Yoda\UserBundle\Entity\User;
use Yoda\UserBundle\Form\RegisterFormType;

class RegisterController extends Controller
{
    /**
     * @Route("/register", name="user_register")a
     * @Template
     */
    public function registerAction(Request $request)
    {
        $defaultUser = new User();
        $defaultUser->setUsername('DefaultUser');
        $defaultUser->setEmail('DefaultEmail@example.com');

        $form = $this->createForm(new RegisterFormType(), $defaultUser);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $user = $form->getData();
                $user->setPassword($this->encodePassword($user, $user->getPlainPassword()));

                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();

                $this->get('session')->getFlashBag()->add('success', 'Registration went smoothly! You are in!');

                $this->authenticateUser($user);

                $url = $this->generateUrl('event');
                return $this->redirect($url);
            }
        }

        return array('form' => $form->createView());
    }

    private function encodePassword($user, $plainPassword)
    {
        $encoder = $this->container->get('security.encoder_factory')
            ->getEncoder($user);


        return $encoder->encodePassword($plainPassword, $user->getSalt());
    }

    private function authenticateUser(UserInterface $user)
    {
        $providerKey = 'secured_area'; // your firewall name
        $token = new UsernamePasswordToken($user, null, $providerKey, $user->getRoles());

        $this->container->get('security.context')->setToken($token);
    }
}