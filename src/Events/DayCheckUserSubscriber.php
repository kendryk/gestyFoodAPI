<?php


namespace App\Events;


use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\DayCheck;
use App\Repository\DayCheckRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Security;

class DayCheckUserSubscriber implements EventSubscriberInterface
{
    private $security;
    private $repository;

// Demande via le constructeur l injection de dépendance auprès de  symfony
//  demande un instance de la classe security et du repository

    public function __construct(Security $security, DayCheckRepository $repository){
        // ce qui permet de recupérer ces instances que symfony nous passe
        $this->security = $security;
        $this->repository = $repository;
    }

    public static function getSubscribedEvents()
    {
        // TODO: Implement getSubscribedEvents() method.
        return [
            KernelEvents::VIEW => ['setUserForDayCheck', EventPriorities::PRE_VALIDATE]
        ];
    }

    public function setUserForDayCheck(ViewEvent $event) {

        $dayCheck = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if ($dayCheck instanceof DayCheck && $method === "POST") {
            $user = $this->security->getUser();
            $dayCheck->setCreatedBy($user);

            if(empty($dayCheck->getCreatedAt())){
                $dayCheck->setCreatedAt(new \DateTime());
                $dayCheck->setUpdateAt(new \DateTime());
            }
            else{
                $dayCheck->setUpdateAt(new \DateTime());
            }
        }
    }
}