<?php

namespace AppBundle\Doctrine;

use AppBundle\Entity\User;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;

class UserPasswordListener
{
    private $encoder;

    public function __construct(UserPasswordEncoder $encoder)
    {
        $this->encoder = $encoder;
    }

    public function prePersist(LifecycleEventArgs $event)
    {
        $user = $event->getEntity();
        if (!$user instanceof User) {
            return null;
        }
        if ($user->getPlainPassword()) {
            // encode password
            $encodedPassword = $this->encoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($encodedPassword);
        }
    }
}
