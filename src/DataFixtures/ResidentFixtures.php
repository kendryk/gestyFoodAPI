<?php

namespace App\DataFixtures;

use App\Entity\Resident;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ResidentFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        for($f=1; $f< 4; $f++){
            for($i=1; $i< 3; $i++){
                for($j=1; $j< 3; $j++){

                    $number =  random_int(1,9);
                    $resident = new Resident();
                    $resident->setFirstName('nom'.$j );
                    $resident->setLastName('prénom'.$j );
                    $resident->setRoom('chambre'.$j );
                    $resident->setBornAt(new\DateTime("1965/04/2".$j ));
                    $resident->setCreatedAt(new\DateTime("2021/04/2".$j ));
                    $resident->setUpdateAt(new\DateTime("2021/04/2".$j ));
                    $resident->setUnity($this->getReference("Unit-".$i."/Foyer-".$f));
                    $resident->setCreatedBy($this->getReference('user-director-1'));
                    $resident->addDiet($this->getReference('Regime-'.$number));
                    $resident->addTexture($this->getReference('texture-'.$number));


                    $manager->persist($resident);

                    $this->addReference("Resident-".$j."/Unit-".$i."/Foyer-".$f, $resident);
                }
            }
        }



        $manager->flush();
    }
    public function getDependencies()
    {
        return [
            UnityFixtures::class,

        ];
    }


}
