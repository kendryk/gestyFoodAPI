<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{

    /**
     *l'encoder de mots de passe
     * @var UserPasswordEncoderInterface
     **/
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        //************ROLE_ADMIN*****************

        $admin = new User();
        $admin->setEmail("admin@live.fr");
        $admin->setFirstName("admin");
        $admin->setLastName("admin");
        $admin->setWork("admin");
        $admin->setCreatedAt(new\DateTime("2021/04/22"));
        $admin->setUpdateAt(new\DateTime("2021/04/22"));
        $admin->setRoles(["ROLE_ADMIN"]);
        $password = $this->encoder->encodePassword($admin,"admin");
        $admin->setPassword($password);

        $this->addReference("user-admin",$admin);

        $manager->persist($admin);





        //************ROLE_DIRECTOR*****************
        for($i=1; $i< 4; $i++) {

            $director = new User();
            $director->setEmail("director".$i."@live.fr");
            $director->setFirstName("director-".$i);
            $director->setLastName("director-".$i);
            $director->setWork("director-".$i);
            $director->setCreatedAt(new\DateTime("2021/04/22"));
            $director->setUpdateAt(new\DateTime("2021/04/22"));
            $director->setRoles(["ROLE_DIRECTOR"]);
            $password = $this->encoder->encodePassword($director, "director-".$i);
            $director->setPassword($password);

            $manager->persist($director);
            $this->addReference("user-director-".$i, $director);

        }


        //************ROLE_MODERATOR*****************
        $moderateur = new User();
        $moderateur->setEmail("moderateur@live.fr");
        $moderateur->setFirstName("moderateur");
        $moderateur->setLastName("moderateur");
        $moderateur->setWork("moderateur");
        $moderateur->setCreatedAt(new\DateTime("2021/04/22"));
        $moderateur->setUpdateAt(new\DateTime("2021/04/22"));
        $moderateur->setRoles(["ROLE_MODERATOR"]);
        $password = $this->encoder->encodePassword($moderateur,"root");
        $moderateur->setPassword($password);

        $manager->persist($moderateur);
        $this->addReference("moderateur",$moderateur);


        //************ROLE_EDITOR*****************
        $editor = new User();
        $editor->setEmail("editor@live.fr");
        $editor->setFirstName("editor");
        $editor->setLastName("editor");
        $editor->setWork("editor");
        $editor->setCreatedAt(new\DateTime("2021/04/22"));
        $editor->setUpdateAt(new\DateTime("2021/04/22"));
        $editor->setRoles(["ROLE_EDITOR"]);
        $password = $this->encoder->encodePassword($editor,"root");
        $editor->setPassword($password);

        $manager->persist($editor);
        $this->addReference("editor",$editor);



        //************ROLE_USER*****************
        $user = new User();
        $user->setEmail("user@live.fr");
        $user->setFirstName("user");
        $user->setLastName("user");
        $user->setWork("user");
        $user->setCreatedAt(new\DateTime("2021/04/22"));
        $user->setUpdateAt(new\DateTime("2021/04/22"));
        $user->setRoles(["ROLE_USER"]);
        $password = $this->encoder->encodePassword($user,"root");
        $user->setPassword($password);

        $manager->persist($user);
        $this->addReference("user",$user);


        $manager->flush();
    }
}
