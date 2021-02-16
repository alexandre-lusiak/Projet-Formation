<?php

namespace App\DataFixtures;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{   
    ///////////////////////////////////////////////////
    // creation of a fake user who will be our admin //
    ///////////////////////////////////////////////////
    private $passwordEncoder;

     public function __construct(UserPasswordEncoderInterface $passwordEncoder)
     {
         $this->passwordEncoder = $passwordEncoder;
     }
     
     public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setEmail("admin@hotmail.fr");

         $user->setPassword($this->passwordEncoder->encodePassword(
             $user,
             'zook'
         ));
        $manager->persist($user);

        $manager->flush();


    }
}
