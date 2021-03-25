<?php


namespace App\Events;


use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\Resident;
use App\Repository\ResidentRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Security;

class ResidentUserSubscriber implements EventSubscriberInterface
{
    private $security;
    private $repository;

// Demande via le constructeur l injection de dépendance auprès de  symfony
//  demande un instance de la classe security et du repository

    public function __construct(Security $security, ResidentRepository $repository){
        // ce qui permet de recupérer ces instances que symfony nous passe
        $this->security = $security;
        $this->repository = $repository;
    }

    public static function getSubscribedEvents()
    {
        // TODO: Implement getSubscribedEvents() method.
        return [
            KernelEvents::VIEW => ['setUserForResident', EventPriorities::PRE_VALIDATE]
        ];
    }

    public function setUserForResident(ViewEvent $event) {

        $resident = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if ($resident instanceof Resident && $method === "POST") {
            $user = $this->security->getUser();
            $resident->setCreatedBy($user);

            if(empty($resident->getCreatedAt())){
                $resident->setCreatedAt(new \DateTime());
                $resident->setUpdateAt(new \DateTime());
            }
            else{
                $resident->setUpdateAt(new \DateTime());
            }
        }
    }
}