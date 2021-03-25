<?php


namespace App\Events;


use ApiPlatform\Core\EventListener\EventPriorities;

use App\Entity\User;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class UserDateSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::VIEW => ['setUserForLogin', EventPriorities::PRE_VALIDATE]
        ];
    }

    public function setUserForLogin(ViewEvent $event) {
        $user = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if ($user instanceof User && $method === "POST") {

            if(empty($user->getCreatedAt())){
                $user->setCreatedAt(new \DateTime());
                $user->setUpdateAt(new \DateTime());
            }
            else{
                $user->setUpdateAt(new \DateTime());
            }
        }

    }
}