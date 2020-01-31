<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Product;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i =0; $i <= 100; ++$i) {
             $product = new Product();
        $product->setName('iPhone ' .$i);
        $product->setDescription('Un iPhone de '.rand(2000,2020));
        $product->setPrice(rand(10,1000)*100);
        $product->setslug('iPhone'.$i);
        $manager->persist($product);
        }
       
        $manager->flush();
    }
}
