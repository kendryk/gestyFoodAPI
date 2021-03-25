<?php

namespace App\DataFixtures;

use App\Entity\Hearth;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class HearthFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
            // create  3 hearth! Bam!


        for($i=1; $i< 4; $i++){

            $hearth = new Hearth();
            $hearth->setName('Foyer-'.$i);
            $hearth->setAddress('rue'.$i);
            $hearth->setCity('Ville'.$i);
            $hearth->setPhone($i.$i.$i.$i );
            $hearth->setEmail('Mail'.$i);
            $hearth->setCreatedAt(new\DateTime("2021/04/2".$i));
            $hearth->setUpdateAt(new\DateTime("2021/04/2".$i));
            $hearth->setCreatedBy($this->getReference('user-director-1'));
            $manager->persist( $hearth);
            $this->addReference("Foyer-".$i,$hearth);
        }

        $manager->flush();
    }
    public function getDependencies()
    {
        return [
            UserFixtures::class,

        ];
    }


}
