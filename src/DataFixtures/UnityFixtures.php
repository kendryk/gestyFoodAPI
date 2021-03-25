<?php

namespace App\DataFixtures;

use App\Entity\Unity;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class UnityFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
            // create 2 Unit for 3 hearth! Bam!


        for($i=1; $i< 4; $i++){
            for($j=1; $j< 3; $j++){
                $unit = new Unity();
                $unit->setName('Unit-'.$j);
                $unit->setPhoto('PhotoUnit'.$j.'.jpg');
                $unit->setCreatedAt(new\DateTime("2021/04/2".$j));
                $unit->setUpdateAt(new\DateTime("2021/04/2".$j));
                $unit->setHearth($this->getReference("Foyer-".$i));
                $unit->setCreatedBy($this->getReference('user-director-1'));
                $manager->persist( $unit);

                $this->addReference("Unit-".$j."/Foyer-".$i,$unit);
            }
        }
//





        $manager->flush();
    }
    public function getDependencies()
    {
        return [
            HearthFixtures::class,

        ];
    }

}
