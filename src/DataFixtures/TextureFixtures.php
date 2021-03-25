<?php

namespace App\DataFixtures;

use App\Entity\Texture;
use Doctrine\Bundle\FixturesBundle\Fixture;

use Doctrine\Persistence\ObjectManager;

class TextureFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

            for($i=1; $i< 10; $i++) {

                $texture = new Texture();
                $texture->setName("texture-".$i);
                $texture->setCreatedAt(new\DateTime("2021/04/2".$i));
                $texture->setUpdateAt(new\DateTime("2021/04/2".$i));
                $texture->setCreatedBy($this->getReference('user-director-1'));

                $this->addReference("texture-".$i, $texture);
                $manager->persist($texture);

            }

        $manager->flush();
    }

}
