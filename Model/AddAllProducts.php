<?php

namespace M2M\ProductsFromApi\Model;

use \Magento\Framework\HTTP\Client\Curl;
use \Magento\Catalog\Model\ProductFactory as ProductModel;
use \Magento\Catalog\Model\ResourceModel\Product as ProductResourceModel;
use \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory as ProductCollection;

class AddAllProducts
{
    /**
     * @var Curl
     */
    protected $curl;

    /**
     * @var ProductModel
     */
    protected $productModel;

    /**
     * @var ProductResourceModel
     */
    protected $productResourceModel;

    /**
     * @var ProductCollection
     */
    protected $productCollection;

    public function __construct(
        Curl $curl,
        ProductModel $productModel,
        ProductResourceModel $productResourceModel,
        ProductCollection $productCollection,
    ) {
        $this->curl = $curl;
        $this->productModel = $productModel;
        $this->productResourceModel = $productResourceModel;
        $this->productCollection = $productCollection;
    }

    public function addProducts()
    {
        // $product = $this->productModel->create();

        $url = "https://fakestoreapi.com/products";

        $this->curl->get($url);

        $result = $this->curl->getBody();

        $products = json_decode($result, true);
        // var_dump($products);

        foreach ($products as $value) {
            $product = $this->productModel->create();

            // $product->setSku(substr($value['title'], 0, 30))
            $product->setSku((string)$value['id'])
            ->setName($value['title'])
            ->setPrice($value['price'])
            ->setVisibility(4)
            ->setStatus(1); 

            $this->productResourceModel->save($product);
        }
    }

    public function getProducts()
    {
        $collection = $this->productCollection->create()->getData();
        print(print_r($collection,true)); die;
    }

}