<?php

namespace App\DataFixtures;

use App\Entity\Hearth;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class HearthFixtures extends Fixture
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
            $manager->persist( $hearth);
            $this->addReference("Foyer-".$i,$hearth);
        }

            $hearth999 = new Hearth();
            $hearth999->setName('Foyer-999');
            $hearth999->setAddress('rue 999');
            $hearth999->setCity('Ville 999');
            $hearth999->setPhone( 999);
            $hearth999->setEmail('Mail 999');
            $hearth999->setCreatedAt(new\DateTime("2021/04/21"));
            $manager->persist( $hearth999);
            $this->addReference("Foyer-999",$hearth999);




        $manager->flush();
    }



}
