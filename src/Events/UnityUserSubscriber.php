<?php


namespace App\Events;


use ApiPlatform\Core\EventListener\EventPriorities;

use App\Entity\Unity;
use App\Repository\UnityRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Security;

class UnityUserSubscriber implements EventSubscriberInterface
{

    private $security;
    private $repository;

// Demande via le constructeur l injection de dépendance auprès de  symfony
//  demande un instance de la classe security et du repository

    public function __construct(Security $security, UnityRepository $repository){
        // ce qui permet de recupérer ces instances que symfony nous passe
        $this->security = $security;
        $this->repository = $repository;
    }

    public static function getSubscribedEvents(): array
    {
        // TODO: Implement getSubscribedEvents() method.
        return [
            KernelEvents::VIEW => ['setUserForUnity', EventPriorities::PRE_VALIDATE]
        ];
    }

    public function setUserForUnity(ViewEvent $event) {

        $unity = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if ($unity instanceof Unity && $method === "POST") {
            $user = $this->security->getUser();
            $unity->setCreatedBy($user);

            if(empty($unity->getCreatedAt())){
                $unity->setCreatedAt(new \DateTime());
                $unity->setUpdateAt(new \DateTime());
            }
            else{
                $unity->setUpdateAt(new \DateTime());
            }
        }
    }

}