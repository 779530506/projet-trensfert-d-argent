<?php

namespace App\DataFixtures;

use App\Entity\Role;
use Faker\Factory;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
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
        for ($i = 0; $i < 50; $i++) {
            $user = new user();
            $user->setNom($faker->lastName);
            $user->setPrenom($faker->name);
            $user->setTelephon($faker->numberBetween(770000000, 779999999));
            $user->setUsername($faker->name);
            $user->setPassword($faker->name);
            $user->setEmail($faker->email);
            $user->setRole($roleAdminSystem);
            $manager->persist($user);
        }


        $manager->flush();
    }
}
