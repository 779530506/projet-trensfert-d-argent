<?php

namespace App\DataFixtures;

use App\Entity\Role;
use Faker\Factory;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encode;
    public function __construct(UserPasswordEncoderInterface $encode)
    {
      $this->encode=$encode;   
    }
    public function load(ObjectManager $manager)
    { //le role admin systeme
       $roleAdminSystem=new Role();
       $roleAdminSystem->setLibelle("adminSystem");
       $manager->persist($roleAdminSystem);
       //le role admin
       $roleAdmin=new Role();
       $roleAdmin->setLibelle("admin");
       $manager->persist($roleAdmin);
       //le role caissier
       $roleCaissier=new Role();
       $roleCaissier->setLibelle("caissier");
       $manager->persist($roleCaissier);

       $manager->flush();

        $faker = Factory::create('fr_FR');

        // on créé 10 users
        for ($i = 0; $i < 5; $i++) {
            $user = new user();
            $user->setNom($faker->lastName);
            $user->setPrenom($faker->name);
            $user->setTelephon($faker->phoneNumber);
            $user->setUsername($faker->userName);
            $user->setDateNaissance($faker->dateTimeBetween('-100 days', '-1 days'));
            $user->setPassword($this->encode->encodePassword($user,'admin'));
            $user->setEmail($faker->email);
            $user->setAdresse($faker->address);
            $user->setIsActive($faker->boolean(true));
            $user->setRoles(["ROLE_SUPADMIN"]);
            $user->setRole($roleAdminSystem);
            $manager->persist($user);
        }


        $manager->flush();
    }
}
