<?php

namespace App\DataFixtures;

use App\Entity\Day;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class DayFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $days = [ 'Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi','Dimanche'];

        for($f=1; $f< 4; $f++){
            for($i=1; $i< 3; $i++) {
                for ($j = 1; $j < 3; $j++) {

                    foreach ($days as $jour) {
                        $day = new Day();
                        $day->setName($jour);
                        $day->setChecktime('matin|midi|soir');
                        $day->setHearth($this->getReference("Foyer-1"));
                        $day->setDayCheck($this->getReference("/Week-1" . "/Resident-" . $j . "/Unit-" . $i . "/Foyer-" . $f));

                        $manager->persist($day);
                        $this->addReference($jour."/Week-1" . "/Resident-" . $j . "/Unit-" . $i . "/Foyer-" . $f, $day);

                        $manager->flush();
                    }

                }
            }
        }

    }


    public function getDependencies()
    {
        return [
            UserFixtures::class,
            ResidentFixtures::class,
            DayCheckFixtures::class
        ];
    }
}
