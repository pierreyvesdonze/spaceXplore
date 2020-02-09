<?php

namespace App\DataFixtures;

use App\Entity\Brand;
use App\Entity\Car;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 20; $i++) {
            $fakeBrand = new Brand();
            $fakeBrand->setName($faker->company);
            
            $fakeCar = new Car();
            $fakeCar->setBrand($fakeBrand);
            $fakeCar->setBrochureFilename($faker->imageUrl($width = 640, $height = 480));

            $manager->persist($fakeBrand);

            $fakeCar->setModel('car_' . $i);
            $fakeCar->setYear($faker->dateTimeBetween("-100 years", "-5 years"));

            $manager->persist($fakeCar);
        } 
        
        $manager->flush();
    }
}
