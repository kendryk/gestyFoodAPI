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
    //TODO:
    // 1. Find user connect(security)
    // 2. find repository hearth( hearthRepository)
    // 2.1 Assigner user au foyer qu'on crée
    // 3. Recup the last hearth insert and get the createDate and Update
    // 4. And modif the date of CreateDate and Update

    private $security;
    private $repository;

// Demande via au constructeur l injection de dépendance auprès de  symfony
//  demande un instance de la classe security et du repository
    public function __construct(Security $security, HearthRepository $repository){
        // ce qui permet de recupérer ces instances que symfony nous passe
        $this->security = $security;
        $this->repository = $repository;
    }

    public static function getSubscribedEvents()
    {
        // TODO: Implement getSubscribedEvents() method.
        return [
            KernelEvents::VIEW => ['setUserForHearts', EventPriorities::PRE_VALIDATE]
        ];
    }

    public function setUserForHearts(ViewEvent $event) {

        $hearth = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if ($hearth instanceof Hearth && $method === "POST") {
            $user = $this->security->getUser();
            $hearth->setCreatedBy($user);

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