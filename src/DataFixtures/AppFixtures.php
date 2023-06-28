<?php

namespace App\DataFixtures;

use App\Entity\Participant;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Generator;
use Faker\Factory;

class AppFixtures extends Fixture
{
    private Generator $faker;

    public function __construct(){
        $this->faker=Factory::create('fr_FR');
    }
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 20; $i++) {
            $participant = new Participant();
            $participant->setFirstname($this->faker->firstName);
            $participant->setLastname($this->faker->lastName);
            $participant->setPhone($this->faker->phoneNumber);
            $participant->setActive($this->faker->boolean);
            $participant->setOrganiser($this->faker->boolean);
            //$participant->setUser();
            $manager->persist($participant);
        }
            $manager->flush();

        //user
//        $user= new User();
//        for($j=1;$j<=20;$j++){
//        $user->setUsername($this->faker->firstName);
//        $user->setPassword($this->faker->password);
//        $user->setEmail($this->faker->email);
//        $manager->persist($user);
//        }
//        $manager->flush();

    }
}
