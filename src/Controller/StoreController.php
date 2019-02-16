<?php

namespace App\Controller;

use App\Entity\Store\Brand;
use App\Entity\Store\Product;
use App\Repository\Store\BrandRepository;
use App\Repository\Store\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/store", name="store_")
 */
class StoreController extends AbstractController
{
    private $productRepository;
    private $brandRepository;

    public function __construct(ProductRepository $productRepository, BrandRepository $brandRepository)
    {
        $this->productRepository = $productRepository;
        $this->brandRepository = $brandRepository;
    }

    /**
     * @Route("/products", name="products")
     */
    public function products()
    {
       // $em = $this->getDoctrine()->getManager();
       // $products = $em->getRepository(Product::class)->findAll();
       // $brands = $em->getRepository(Brand::class)->findAll();

        return $this->render('store/products.html.twig', [
            'products' => $this->productRepository->findAll(),
            'brands' =>$this->brandRepository->findAll()
        ]);
    }

    /**
     * @Route("/product/{id}/details/{slug}", name="product", requirements={"id" = "\d+"})
     */
    public function product(int $id, string $slug)
    {
        $em = $this->getDoctrine()->getManager();
        //$productrepository = $em->getRepository(Product::class);
        $product= $this->productRepository->find($id);
        $brands = $em->getRepository(Brand::class)->findAll();

        if(!$product || $product->getSlug()  !== $slug){
            throw $this->createNotFoundException();
        }
        return $this->render('store/product.html.twig', [
            'product'=> $product,
            'brands' => $brands
        ]);
    }

    public function brandList(int $currentBrandId = null)
    {
        //template partial s'écrit avec _ donc store/_brand.html...
        return $this->render( 'store/brand.html.twig', [
            'brands' =>$this->brandRepository->findAll(),
            'currentBrandId' =>$currentBrandId
        ]);
    }
}
