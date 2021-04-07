<?php

namespace App\Events;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\Hearth;
use App\Repository\HearthRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Security;


class HearthUserSubscriber implements EventSubscriberInterface{


    public static function getSubscribedEvents()
    {

        return [
            KernelEvents::VIEW => ['setUserForHearts', EventPriorities::PRE_VALIDATE]
        ];
    }

    public function setUserForHearts(ViewEvent $event) {

        $hearth = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if ($hearth instanceof Hearth && ($method === "PUT" || $method === "POST")) {

            if(empty($hearth->getCreatedAt())){
                $hearth->setCreatedAt(new \DateTime());
                $hearth->setUpdateAt(new \DateTime());
            }
            else{
                $hearth->setUpdateAt(new \DateTime());
            }
        }
    }

}