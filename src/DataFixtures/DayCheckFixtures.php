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



        for($f=1; $f< 4; $f++){
            for($i=1; $i< 3; $i++) {
                for ($j = 1; $j < 3; $j++) {
                    $number =  random_int(1,9);
                        $dayCheck = new DayCheck();
                        $dayCheck->setName("1");
                        $dayCheck->setResident($this->getReference("Resident-" . $j . "/Unit-" . $i . "/Foyer-" . $f));
                        $dayCheck->setCreatedAt(new\DateTime("2021/01/0".$i));
                        $dayCheck->setCreatedBy($this->getReference('user-director-1'));
                        $dayCheck->setHearth($this->getReference("Foyer-1"));
                        $dayCheck->setDiet($this->getReference('Regime-'.$number));
                        $dayCheck->setTexture($this->getReference('texture-'.$number));
                        $manager->persist($dayCheck);
                        $this->addReference("/Week-1" . "/Resident-" . $j . "/Unit-" . $i . "/Foyer-" . $f, $dayCheck);
                        $manager->flush();


                }
            }
        }

    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
            ResidentFixtures::class

        ];
    }

}
