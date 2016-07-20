<?php

namespace AppBundle\Security;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

class FormLoginAuthenticator extends AbstractGuardAuthenticator
{
    private $em;
    private $encoder;
    private $router;

    public function __construct(EntityManager $em, UserPasswordEncoder $encoder, RouterInterface $router)
    {
        $this->em = $em;
        $this->encoder = $encoder;
        $this->router = $router;
    }

    public function getCredentials(Request $request)
    {
        if ($request->isMethod('POST')) {
            if ($request->request->has('username')) {
                return [
                    'username' => $request->request->get('username'),
                    'password' => $request->request->get('plain_password'),
                ];
            }
        }

        return null;
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        return $this->em->getRepository(User::class)->findOneBy([
            'username' => $credentials['username'],
        ]);
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        return $this->encoder->isPasswordValid($user, $credentials['password']);
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        return null;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        $url = $this->router->generate('admin_blog_show');

        return new RedirectResponse($url);
    }

    public function supportsRememberMe()
    {
        return false;
    }

    public function start(Request $request, AuthenticationException $authException = null)
    {
        return null;
    }
}
