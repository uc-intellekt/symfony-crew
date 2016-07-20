<?php

namespace AppBundle\Controller;

use AppBundle\Form\UserLoginType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SecurityController extends Controller
{
    /**
     * @Route("/login", name="security_login")
     */
    public function loginAction()
    {
        if ($this->getUser()) {
            $this->addFlash('warning', 'You\'re already logged  in.');
        }

        $form = $this->createForm(UserLoginType::class, null, [
            'action' => $this->generateUrl('security_check'),
        ]);

        return $this->render('security/login.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/login/check", name="security_check")
     */
    public function checkAction()
    {
        throw new \Exception('Should be never executed!');
    }

    /**
     * @Route("/logout", name="security_logout")
     */
    public function logoutAction()
    {
        throw new \Exception('Should be never executed!');
    }
}
