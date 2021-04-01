<?php


namespace App\Events;


use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;

class JwtCreatedSubscriber
{

    public  function updateJwtData(JwtCreatedEvent $event)
    {
        /**
         * Récuperation de l'users!
         */
        $user = $event->getUser();
        /**
         * customiser les données !
         */
        $data = $event->getData();
        $data['firstName']= $user->getFirstName();
        $data['lastName']= $user->getLastName();

        $event ->setData($data);





    }
}