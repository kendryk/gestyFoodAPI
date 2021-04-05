<?php

namespace App\DataFixtures;

use App\Entity\Diet;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class DietFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        for($i=1; $i< 10; $i++) {

            $diet = new Diet();
            $diet->setName("Regime-".$i);
            $diet->setCreatedAt(new\DateTime("2021/04/2".$i));
            $diet->setUpdateAt(new\DateTime("2021/04/2".$i));
            $diet->setCreatedBy($this->getReference('user-director-1'));
            $diet->setHearth($this->getReference("Foyer-1"));
            $this->addReference("Regime-".$i, $diet);

            $manager->persist($diet);

        }

        $manager->flush();
    }
    public function getDependencies()
    {
        return [
            UserFixtures::class

        ];
    }

}
