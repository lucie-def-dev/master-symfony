<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Product;
use App\Entity\User;
use Symfony\Component\String\Slugger\SluggerInterface;

class AppFixtures extends Fixture

{
/**
 * @var SluggerInterface
 */
    private $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');

        $users = [];
        for($i =1 ; $i <=10 ; ++$i) {
            $user = new User();
            $user->setUsername($faker->email);
            $manager->persist($user);
            $users[] = $user;

        }

        for ($i =0; $i <= 100; ++$i) {
             $product = new Product();
        $product->setName('iPhone ' .$i);
        $product->setSlug($this->slugger->slug($product->getName())->lower());
        $product->setDescription('Un iPhone de '.rand(2000,2020));
        $product->setPrice(rand(10,1000)*100);
        $product->setUser($users[rand(0,9)]);
        $manager->persist($product);
        }
       
        $manager->flush();
    }
}
