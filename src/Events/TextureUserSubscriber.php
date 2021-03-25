<?php


namespace App\Events;


use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\Texture;
use App\Repository\TextureRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Security;

class TextureUserSubscriber implements EventSubscriberInterface
{
    private $security;
    private $repository;

// Demande via le constructeur l injection de dépendance auprès de  symfony
//  demande un instance de la classe security et du repository

    public function __construct(Security $security, TextureRepository $repository){
        // ce qui permet de recupérer ces instances que symfony nous passe
        $this->security = $security;
        $this->repository = $repository;
    }

    public static function getSubscribedEvents()
    {
        // TODO: Implement getSubscribedEvents() method.
        return [
            KernelEvents::VIEW => ['setUserForTexture', EventPriorities::PRE_VALIDATE]
        ];
    }

    public function setUserForTexture(ViewEvent $event) {

        $texture = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if ($texture instanceof Texture && $method === "POST") {
            $user = $this->security->getUser();
            $texture->setCreatedBy($user);

            if(empty($texture->getCreatedAt())){
                $texture->setCreatedAt(new \DateTime());
                $texture->setUpdateAt(new \DateTime());
            }
            else{
                $texture->setUpdateAt(new \DateTime());
            }
        }
    }
}