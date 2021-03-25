<?php

namespace App\DataFixtures;

use App\Entity\DayCheck;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class DayCheckFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {

        $daysWeek = [ 'Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi','Dimanche'];

        for($f=1; $f< 4; $f++){
            for($i=1; $i< 3; $i++) {
                for ($j = 1; $j < 3; $j++) {

                    foreach ($daysWeek as $jour) {
                        $dayCheck = new DayCheck();
                        $dayCheck->setName($jour);
                        $dayCheck->setChecktime('matin/midi/soir');
                        $dayCheck->setResident($this->getReference("Resident-" . $j . "/Unit-" . $i . "/Foyer-" . $f));
                        $dayCheck->setCreatedAt(new\DateTime("2021/04/2".$i));
                        $dayCheck->setUpdateAt(new\DateTime("2021/04/2".$i));
                        $dayCheck->setCreatedBy($this->getReference('user-director-1'));
                        $dayCheck->setWeek('Semaine-1');
                        $manager->persist($dayCheck);
                        $this->addReference($jour."/Resident-" . $j . "/Unit-" . $i . "/Foyer-" . $f, $dayCheck);

                        $manager->flush();
                    }

                }
            }
        }
    }

    public function getDependencies()
    {
        return [
            ResidentFixtures::class,

        ];
    }

}
