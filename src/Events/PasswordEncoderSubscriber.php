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

        return [
            KernelEvents::VIEW => ['encodePassword', EventPriorities::PRE_WRITE]
        ];
    }
        //fonction permettant d'hasher le password en utilisant l'encoder appelé plus haut
    public function encodePassword(ViewEvent $event)
    {
        $result = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();// recupere une methode  POST GET PUT .....partout


        // verifie si l'user  et la methode alors on encode le password
        if ($result instanceof User && $method === "POST"){
            $hash = $this->encoder->encodePassword($result,$result->getPassword());
            $result->setPassword($hash);
        }
        // hashage du mot de passe lors de la modification de l'user
        if ($result instanceof User && $method === "PUT") {
            $hash = $this->encoder->encodePassword($result, $result->getPassword());
            $result->setPassword($hash);
        }

    }

}