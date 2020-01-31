<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class ProductController extends AbstractController
{
    /**
     * @Route("/product/create", name="product_create")
     */
    public function create(Request $request, SluggerInterface $slugger)
    {   
        $product = new Product();
        // créeation de formulaire , classe du formulaire et objet à ajouter dans la bdd 
        $form = $this->createForm(ProductType::class , $product);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $product->setSlug($slugger->slug($product->getName())->lower());
            //ajouter en bdd
            $entityManager = $this->getDoctrine()->getManager();
            //met l'objet en attente
            $entityManager->persist($product);
            //insert
            $entityManager->flush();

            $this->addFlash('success', 'Le produit à bien été ajouté');
        }
        
        return $this->render('product/create.html.twig' ,[
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route ("/product/product", name="product")
     */

    public function cat() 
    {
       $Repository=  $this->getDoctrine()->getRepository(Product::class);
       $product = $Repository->findAll();  

       

       return $this->render('product/product.html.twig', [
           'product'=>$product,
       ]);
    }
    
    /**
     * @Route ("/product/{slug}", name="product_show")
     */
    public function show($slug)
    {
        dump($slug);
        // on récupére le depot qui contient nos produits
        $productRepository=  $this->getDoctrine()->getRepository(Product::class);
        $product = $productRepository->findOneBy(['slug'=>$slug]);
        
        
        // si le produit existe pas 
        if (!$product) {
            throw $this->createNotFoundException('Le produit n\'existe pas.');
        }

        return $this->render('product/show.html.twig', [
            'product'=>$product,
        ]);
    }
    
    /**
     * @Route("/product/edit/{id}", name="product_edit")
     */
    public function edit(Request $request, Product $product)
    {
        // On crée le formulaire avec le produit à modifier
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Met à jour l'objet dans la BDD
            $this->getDoctrine()->getManager()->flush();

            // Redirige vers la liste des produits après l'UPDATE
            return $this->redirectToRoute('product');
        }

        return $this->render('product/edit.html.twig', [
           'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/product/delete/{id}", name="product_delete")
     */
    public function delete(Product $product, EntityManagerInterface $entityManager)
    {
        $entityManager->remove($product);
        $entityManager->flush();

        return $this->redirectToRoute('product');
    }

}
