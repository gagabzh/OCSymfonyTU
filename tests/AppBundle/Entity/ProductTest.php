<?php
/**
 * Created by PhpStorm.
 * User: bgarnier
 * Date: 28/02/2018
 * Time: 12:53
 */

namespace Tests\AppBundle\Entity;

use PHPUnit\Framework\TestCase;
use AppBundle\Entity\Product;

class ProductTest extends TestCase
{
    /**
     * @dataProvider pricesForFoodProduct
     */
    public function testcomputeTVAFoodProduct($price, $expectedTva)
    {
        $product = new Product('Un produit', Product::FOOD_PRODUCT, $price);

        $this->assertSame($expectedTva, $product->computeTVA());
    }

    public function pricesForFoodProduct()
    {
        return [
            [0, 0.0],
            [20, 1.1],
            [100, 5.5]
        ];
    }
    /**
     * @dataProvider pricesForOtherProduct
     */
    public function testcomputeTVANotFoodProduct($price, $expectedTva)
    {
        $product = new Product('Un produit', 'Viande', $price);

        $this->assertSame($expectedTva, $product->computeTVA());
    }
    public function pricesForOtherProduct()
    {
        return [
            [0, 0.0],
            [20, 3.92],
            [100, 19.6]
        ];
    }
    public function testNegativePriceComputeTVA()
    {
        $product = new Product('Un produit', Product::FOOD_PRODUCT, -20);

        $this->expectException('LogicException');

        $product->computeTVA();
    }
}