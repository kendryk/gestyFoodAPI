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
        $data['id']= $user->getId();
        $data['firstName']= $user->getFirstName();
        $data['lastName']= $user->getLastName();

        $data['hearthId']= $user->getHearth()->getId();
        $data['hearthName']= $user->getHearth()->getName();

        $event ->setData($data);





    }
}