<?php

namespace App\Events;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\User;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class PasswordEncoderSubscriber implements EventSubscriberInterface{


    //construction d'un encodeur de symfony

    /** @var UserPasswordEncoderInterface */
    private $encoder;
    public function __construct(UserPasswordEncoderInterface $encoder){
        $this->encoder = $encoder;
    }

    public static function getSubscribedEvents()
    {
        // TODO: Implement getSubscribedEvents() method.
        return [
            KernelEvents::VIEW => ['encodePassword', EventPriorities::PRE_WRITE]
        ];
    }

    public function encodePassword(ViewEvent $event)
    {
        $result = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();// recupere une methode  POST GET PUT .....partout


        // verifie si il y  user  et la methode alors on encode le password
        if ($result instanceof User && $method === "POST"){

            $hash = $this->encoder->encodePassword($result,$result->getPassword());
            $result->setPassword($hash);
        }

    }

}