<?php

namespace App\Repository\Store;

use App\Entity\Store\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Select;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpKernel\HttpCache\Store;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function findLastProduct()
    {
        return $this
            ->createQueryBuilder('p')
            ->orderBy('p.createdAt', 'DESC')
            ->setMaxResults(4)
            ->getQuery()
            ->getResult();
    }

    public function FindMoreComment()
    {
        return $this
            ->createQueryBuilder('p')
            ->addSelect('o')
            ->leftJoin('p.opinions', 'o')
            //->groupBy('p.id')
            ->orderBy('count(o)', 'DESC')
            ->setMaxResults(4)
            ->groupBy('p')
            ->getQuery()
            ->getResult();
    }

}
