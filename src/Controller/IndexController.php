<?php

namespace App\Controller;

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index()
    {
        $product= new Product();
        $product->setName('iphone');
        $product->setDescription('Mon produit');
        $product->setPrice('999');


        $entityManager = $this->getDoctrine()->getManager();
        // persist = insert
        $entityManager->persist($product);
        // flush execute la requête
        // $entityManager->flush();

        return $this->render('index/homepage.html.twig');
    }
}
