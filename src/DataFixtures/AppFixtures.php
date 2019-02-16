<?php

namespace App\DataFixtures;

use App\Entity\Store\Brand;
use App\Entity\Store\Image;
use App\Entity\Store\Product;
use App\Entity\Store\Color;
use App\Entity\Store\Opinion;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    const LODE ='vnzjkvnzjvnjkvnjkv ndjv ds, vc,ldq cqld cqslk cqsj cjq c
    jondjzenczjenvzjkhbnvej v,c alk ,cak xka ck ce vzjv jrv
    lekdaop,cenjev bzhv berv jrk vzlcvek,mdl,almzd,laz,dlaz,dlzmda
    ceajlcnjecn ezjc nezc ezl cez cl ce e czc ezl clek';

    /**
     * @var ObjectManager
     */
    private $manager;

    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;

        $this->loadImages();
        $this->loadBrands();
        $this->loadColors();
        $this->loadProducts();
        $this->loadOpinions();
    }

    private function loadProducts()
    {
        for ($i = 1; $i < 15; $i++) {
            $product = (new Product())
                ->setName('product '.$i)
                ->setDescription('Produit de description '.$i)
                ->setPrice(mt_rand(10, 100))
                ->setDescriptionLongue(self::LODE)
                ->setSlug('produit-'.$i)
                ->setImage($this->getReference('image'.$i))
                ->setBrand($this->getReference('brand'.random_int(0,3)));

            for($j = 0; $j < 7 ; $j++) {
                if (rand(0,1)) {
                    $product->addColor($this->getReference('color'.$j));
                }
            }

            for($k = 1; $k < 8 ; $k++) {
                if (rand(0,1)) {
                    $product->addOpinion($this->getReference('opinion'.$k));
                }
            }

            $this->manager->persist($product);
        }

        $this->manager->flush();
    }

    private function loadImages(){
        for($i = 1; $i <15; $i++){
            $image = (new Image())
            ->setUrl('shoe-'.$i.'.jpg')
            ->setAlt('Shoe'.$i);

            $this->manager->persist($image);
            $this->addReference('image'.$i, $image);
        }

        $this->manager->flush();
    }

    private function loadBrands(){
        $brandNames=['Adidas', 'Nike', 'Asics', 'Reebok'];

        foreach ($brandNames as $key =>$name){
            $brand = (new Brand())
                ->setName($name);
            $this->manager->persist($brand);
            $this->addReference('brand'.$key, $brand);
        }

        $this->manager->flush();
    }

    private function loadColors(){
        $colorNames =['Blanc', 'Noire', 'Rouge', 'Jaune', 'Rose', 'Brun', 'Bleu'];

        foreach ($colorNames as $key =>$name) {
            $color = (new Color())
                ->setName($name);
            $this->manager->persist($color);
            $this->addReference('color'.$key, $color);
        }
        $this->manager->flush();
    }

    private function loadOpinions(){
        for($i = 1; $i < 10; $i++){
            $opinion = (new Opinion())
                ->setPseudo('pseudo '.$i)
                ->setMessage('message '.$i);

            $this->manager->persist($opinion);
            $this->addReference('opinion'.$i, $opinion);
        }

        $this->manager->flush();
    }
}
