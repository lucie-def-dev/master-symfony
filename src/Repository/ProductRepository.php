<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function findAllGreatherThanPrice($price): array
    {
        //SELECT * FROM PRODUCT WHERE PRICE > 500
        
        // SELECT , id name , description , slug from product p
        $queryBuilder= $this->createQueryBuilder('p') // 'p' alias de product
            ->where('p.price > :price') // dans p (product) on prend le prix 
            ->setParameter('price', $price * 100)
            ->orderBy('p.price', 'ASC')
            ->setMaxResults(4)
            ->getQuery();

        return $queryBuilder->getResult();   
    }


    //recup le produit le plus chére
    public function findOneGreatherThanprice($price): ?Product
    {
        $queryBuilder = $this->createQueryBuilder('p')
            ->where('p.price > :price')
            ->setParameter('price' , $price * 100)
            ->orderBy('p.price','DESC')
            ->getQuery();       
            
            return $queryBuilder->setMaxResults(1)->getOneOrNullResult();
        }

    // /**
    //  * @return Product[] Returns an array of Product objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Product
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
