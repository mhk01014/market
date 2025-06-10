<?php
require_once '..\entity\product.php';
require_once '..\database\dbconnect.php';

class ProductController
{
    private $model;

    public function __construct()
    {
        $this->model = new Product();
    }

    public function getAllProducts()
    {
        return $this->model->getProducts();
    }
}
?>
