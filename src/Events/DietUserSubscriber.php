<?php


namespace App\Events;


use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\Diet;
use App\Repository\DietRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Security;

class DietUserSubscriber implements EventSubscriberInterface
{
    private $security;
    private $repository;

// Demande via le constructeur l injection de dépendance auprès de  symfony
//  demande un instance de la classe security et du repository

    public function __construct(Security $security, DietRepository $repository){
        // ce qui permet de recupérer ces instances que symfony nous passe
        $this->security = $security;
        $this->repository = $repository;
    }

    public static function getSubscribedEvents()
    {
        // TODO: Implement getSubscribedEvents() method.
        return [
            KernelEvents::VIEW => ['setUserForDiet', EventPriorities::PRE_VALIDATE]
        ];
    }

    public function setUserForDiet(ViewEvent $event) {

        $diet = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if ($diet instanceof Diet && $method === "POST") {
            $user = $this->security->getUser();
            $diet->setCreatedBy($user);

            if(empty($diet->getCreatedAt())){
                $diet->setCreatedAt(new \DateTime());
                $diet->setUpdateAt(new \DateTime());
            }
            else{
                $diet->setUpdateAt(new \DateTime());
            }
        }
    }
}